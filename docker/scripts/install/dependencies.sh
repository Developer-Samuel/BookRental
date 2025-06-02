#!/bin/bash
set -e

echo "🔧 Updating packages and installing dependencies..."
apt-get update

apt-get install -y --no-install-recommends \
    git \
    curl \
    unzip \
    ca-certificates \
    gnupg \
    apt-transport-https \
    lsb-release \
    default-mysql-client \
    redis-tools

echo "🟢 Setting up Node.js..."
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt-get install -y nodejs

echo "🔨 Installing PHP extensions..."
docker-php-ext-install pdo pdo_mysql

echo "📦 Installing PHP Redis extension..."
pecl install redis && docker-php-ext-enable redis

echo "🧹 Cleaning up..."
rm -rf /var/lib/apt/lists/*
