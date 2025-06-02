#!/bin/sh
set -e

# 🎨 Format PHP files using PHP CS Fixer
echo "🎯 Running PHP CS Fixer..."
composer fix
echo "✅ Code formatting completed."

# 🔍 Perform static analysis using Larastan (PHPStan tailored for Laravel)
echo "🔬 Running static analysis with Larastan..."
composer analyse
echo "✅ Static analysis completed."

# 🧪 Run Laravel tests using Artisan
echo "🧪 Running Laravel tests..."
./vendor/bin/phpunit -c phpunit.docker.test.xml
echo "✅ Tests finished successfully."
