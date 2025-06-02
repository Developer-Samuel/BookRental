#!/bin/sh
set -e

if [ ! -f .env ]; then
  cp .env.example.docker .env
  echo "✅ Environment file prepared successfully."

  echo "🔑 Generating application key..."
  /usr/local/bin/scripts/bootstrap/generate-key.sh
else
  echo "⚠️ .env file already exists, skipping preparation."
fi
