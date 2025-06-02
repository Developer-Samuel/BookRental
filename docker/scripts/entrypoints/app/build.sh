#!/bin/sh
set -e

if [ -f public/hot ] && ! docker ps --filter "name=book_rental_vite" --filter "status=running" | grep -q book_rental_vite; then
  echo "🧹 Removing public/hot because vite container is not running..."
  rm public/hot
fi

echo "⚙️ Building assets..."
npm run build
echo "✅ Assets built."
