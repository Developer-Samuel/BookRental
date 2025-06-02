#!/bin/sh
set -e

echo "📁 Creating required directories..."
mkdir -p \
  /var/www/storage/framework/sessions \
  /var/www/storage/framework/views \
  /var/www/storage/framework/cache \
  /var/www/storage/logs \
  /var/www/bootstrap/cache

echo "📝 Creating log file if missing..."
if [ ! -f /var/www/storage/logs/laravel.log ]; then
  touch /var/www/storage/logs/laravel.log
  echo "📄 Created empty laravel.log file"
fi

echo "👤 Setting ownership to www-data..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

echo "🔐 Setting permissions..."
find /var/www/storage /var/www/bootstrap/cache -type d -exec chmod 775 {} \;
find /var/www/storage /var/www/bootstrap/cache -type f -exec chmod 664 {} \;

# Optional: Node-related files
[ -f /var/www/package-lock.json ] && chown www-data:www-data /var/www/package-lock.json
[ -d /var/www/node_modules ] && chown -R www-data:www-data /var/www/node_modules
[ -f /var/www/public/hot ] && chown www-data:www-data /var/www/public/hot
[ -d /var/www/public/build ] && chown -R www-data:www-data /var/www/public/build

echo "✅ Permissions and logging setup complete."
