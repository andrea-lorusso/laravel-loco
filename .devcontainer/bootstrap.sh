#!/usr/bin/env bash
set -e
echo "Executing bootstrap script for the devcontainer..."
cd "$(dirname "$0")"

# If the .env file does not exist, copy it from the example
if [ ! -f ../.docker/.env ]; then
   echo "The .env file does not exist. Copying from the example..."
   cp ../.docker/.env.example ../.docker/.env
fi
