#!/bin/sh
set -e

/usr/local/bin/scripts/bootstrap/check-composer.sh

echo "🔄 Preparing environment file (.env.example.docker -> .env)  ==="
/usr/local/bin/scripts/bootstrap/prepare-env.sh

echo "⚙️ Clearing caches and optimizing configuration..."
/usr/local/bin/scripts/bootstrap/optimize.sh
echo "✅ Optimization script finished."

echo "🧹 Clearing Redis cache..."
/usr/local/bin/scripts/entrypoints/app/clear-cache.sh
echo "✅ Redis cache cleared."

echo "🧹 Running code style, static analysis, and test suite..."
/usr/local/bin/scripts/entrypoints/tools/code-quality.sh
echo "✅ Code quality checks finished."

echo "🗃️ Running fresh migrations and seeding database..."
/usr/local/bin/scripts/entrypoints/app/migrate.sh
echo "✅ Migrations and seeding finished."

echo "🔍 Checking node dependencies..."
/usr/local/bin/scripts/bootstrap/node-setup.sh

echo "🔍 Checking frontend build (npm run build)..."
/usr/local/bin/scripts/entrypoints/app/build.sh
