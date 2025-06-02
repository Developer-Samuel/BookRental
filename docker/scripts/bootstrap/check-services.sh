#!/bin/sh
set -e

echo "📡 Checking MySQL server availability..."

until mysqladmin ping -h "$DB_HOST" --silent; do
    echo "⏳ MySQL not ready yet, waiting..."
    sleep 3
done

echo "📡 Checking Redis server availability..."

until redis-cli -h "$REDIS_HOST" -p "$REDIS_PORT" ping | grep -q PONG; do
    echo "⏳ Redis not ready yet, waiting..."
    sleep 3
done

echo "✅ All required services are ready."
