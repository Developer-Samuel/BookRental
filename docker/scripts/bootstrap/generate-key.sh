#!/bin/sh
set -e

if php artisan key:generate; then
  echo "✅ Application key generated successfully!"
else
  echo "❌ Failed to generate application key!"
  exit 1
fi
