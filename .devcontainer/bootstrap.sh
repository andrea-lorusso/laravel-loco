#!/usr/bin/env bash
set -e
echo "Executing bootstrap script for the devcontainer..."
cd "$(dirname "$0")"

# If the .env file does not exist, copy it from the example
if [ ! -f ../.env ]; then
   echo "The .env file does not exist. Copying from the example..."
   cp ../.env.example ../.env
fi

# If the nginx SSL certificate does not exist, generate a self-signed one
if [ ! -f ../.docker/nginx/ssl/default.crt ]; then
   echo "The nginx SSL certificate does not exist. Generating a self-signed one..."
   mkdir -p ../.docker/nginx/ssl
   openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
     -keyout ../.docker/nginx/ssl/default.key \
     -out ../.docker/nginx/ssl/default.crt \
     -subj "/CN=localhost"
fi
