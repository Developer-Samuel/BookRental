#!/bin/sh
set -e

if ! command -v composer >/dev/null 2>&1; then
  echo "🛠️ Installing Composer dependencies (composer.json)"

  EXPECTED_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')"
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

  if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then
    echo '❌ Invalid installer checksum'
    rm composer-setup.php
    exit 1
  fi

  php composer-setup.php --install-dir=/usr/local/bin --filename=composer
  rm composer-setup.php
  echo "✅ Composer installed successfully."
fi
