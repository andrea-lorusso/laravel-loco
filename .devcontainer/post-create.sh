#!/usr/bin/env bash
set -e
cd /var/www

# Capture the DB/Redis values bootstrap.sh already wrote to .env (from .env.example)
# before they get replaced by whatever Laravel's own scaffolding generates.
DOCKER_DB_DATABASE="laravel"
DOCKER_DB_USERNAME="laravel"
DOCKER_DB_PASSWORD="secret"
DOCKER_DB_PORT="3306"
DOCKER_REDIS_PORT="6379"
if [ -f .env ]; then
  set -a
  # shellcheck disable=SC1091
  source .env
  set +a
  DOCKER_DB_DATABASE="${DB_DATABASE:-$DOCKER_DB_DATABASE}"
  DOCKER_DB_USERNAME="${DB_USERNAME:-$DOCKER_DB_USERNAME}"
  DOCKER_DB_PASSWORD="${DB_PASSWORD:-$DOCKER_DB_PASSWORD}"
  DOCKER_DB_PORT="${DB_PORT:-$DOCKER_DB_PORT}"
  DOCKER_REDIS_PORT="${FORWARD_REDIS_PORT:-$DOCKER_REDIS_PORT}"
fi

set_env_var() {
  local key="$1" value="$2"
  touch .env
  sed -i "/^#\{0,1\}[[:space:]]*${key}=/d" .env
  printf '%s=%s\n' "$key" "$value" >> .env
}

if [ ! -f artisan ]; then
  echo "==> No Laravel application detected, scaffolding a fresh install..."
  TMP_DIR="$(mktemp -d)"
  composer create-project laravel/laravel "$TMP_DIR" --prefer-dist --no-interaction

  # Merge the skeleton into the workspace without clobbering the devcontainer's
  # own files (.git, .gitignore, README, LICENSE, .env, .env.example).
  shopt -s dotglob nullglob
  for item in "$TMP_DIR"/*; do
    base="$(basename "$item")"
    lower="${base,,}"
    case "$lower" in
      .git|.gitignore|.env.example|readme.md|license.md|license) continue ;;
    esac
    if [ "$base" = "storage" ]; then
      # Keep the existing bind-mounted mysqldata/redisdata directories intact.
      cp -a "$item/." "./storage/"
      continue
    fi
    rm -rf "./$base"
    mv "$item" "./$base"
  done
  rm -rf "$TMP_DIR"
fi

composer install --no-interaction

[ -f .env ] || cp .env.example .env

# Point the freshly scaffolded app at the containers docker-compose already provisioned.
set_env_var APP_URL "https://lvh.me"
set_env_var DB_CONNECTION mysql
set_env_var DB_HOST laravel_loco_mysql
set_env_var DB_PORT "$DOCKER_DB_PORT"
set_env_var DB_DATABASE "$DOCKER_DB_DATABASE"
set_env_var DB_USERNAME "$DOCKER_DB_USERNAME"
set_env_var DB_PASSWORD "$DOCKER_DB_PASSWORD"
set_env_var REDIS_HOST laravel_loco_redis
set_env_var REDIS_PORT "$DOCKER_REDIS_PORT"
set_env_var SESSION_DRIVER redis
set_env_var CACHE_STORE redis
set_env_var QUEUE_CONNECTION redis

if ! grep -q '^APP_KEY=base64' .env 2>/dev/null; then
  php artisan key:generate --force
fi

echo "==> Waiting for MySQL to accept connections..."
for _ in $(seq 1 15); do
  php artisan db:show >/dev/null 2>&1 && break
  sleep 2
done

php artisan migrate --force

# Keep .env.example in sync (secret-free) so teammates can bootstrap from it too.
cp .env .env.example
sed -i "s/^APP_KEY=.*/APP_KEY=/" .env.example

if [ -f package.json ]; then
  npm install

  # Bind Vite to 0.0.0.0 so the HMR port forwarded by the devcontainer actually works.
  if [ -f vite.config.js ] && ! grep -q "host: '0.0.0.0'" vite.config.js; then
    sed -i "s/export default defineConfig({/export default defineConfig({\n    server: {\n        host: '0.0.0.0',\n        port: 5173,\n        strictPort: true,\n        hmr: { host: 'localhost' },\n    },/" vite.config.js
  fi
fi

echo "==> Bootstrap complete. Application available at https://lvh.me/"
