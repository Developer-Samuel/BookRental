# 📁 docker/Dockerfile

FROM php:8.3-fpm

# Copy custom PHP configuration files (opcache, php-fpm pool)
COPY php/config/php.ini /usr/local/etc/php/conf.d/opcache.ini
COPY php/config/www.conf /usr/local/etc/php-fpm.d/www.conf

# Copy custom Redis configuration files
COPY redis/config/redis.conf /usr/local/etc/redis/redis.conf

# Copy and run dependency installer script
COPY scripts/install/dependencies.sh /usr/local/bin/scripts/install/dependencies.sh
RUN chmod +x /usr/local/bin/scripts/install/dependencies.sh && /usr/local/bin/scripts/install/dependencies.sh

# Copy and run permissions fixing script to ensure correct file permissions
COPY scripts/bootstrap/permissions.sh /usr/local/bin/scripts/bootstrap/permissions.sh
RUN chmod +x /usr/local/bin/scripts/bootstrap/permissions.sh && /usr/local/bin/scripts/bootstrap/permissions.sh

WORKDIR /var/www

# Copy bootstrap scripts for environment preparation and optimization
COPY scripts/bootstrap/check-composer.sh /usr/local/bin/scripts/bootstrap/check-composer.sh
COPY scripts/bootstrap/composer/install.sh /usr/local/bin/scripts/bootstrap/composer/install.sh
COPY scripts/bootstrap/composer/update.sh /usr/local/bin/scripts/bootstrap/composer/update.sh
COPY scripts/bootstrap/check-services.sh /usr/local/bin/scripts/bootstrap/check-services.sh
COPY scripts/bootstrap/prepare-env.sh /usr/local/bin/scripts/bootstrap/prepare-env.sh
COPY scripts/bootstrap/generate-key.sh /usr/local/bin/scripts/bootstrap/generate-key.sh
COPY scripts/bootstrap/optimize.sh /usr/local/bin/scripts/bootstrap/optimize.sh
COPY scripts/bootstrap/node-setup.sh /usr/local/bin/scripts/bootstrap/node-setup.sh

# Copy entrypoint scripts related to app lifecycle tasks (migrations, build, tests, cache)
COPY scripts/entrypoints/tools/code-quality.sh /usr/local/bin/scripts/entrypoints/tools/code-quality.sh
COPY scripts/entrypoints/app/migrate.sh /usr/local/bin/scripts/entrypoints/app/migrate.sh
COPY scripts/entrypoints/app/build.sh /usr/local/bin/scripts/entrypoints/app/build.sh
COPY scripts/entrypoints/app/clear-cache.sh /usr/local/bin/scripts/entrypoints/app/clear-cache.sh

# Copy general entrypoint and server start scripts
COPY scripts/entrypoints/setup.sh /usr/local/bin/scripts/entrypoints/setup.sh
COPY scripts/entrypoints/server/start.sh /usr/local/bin/scripts/entrypoints/server/start.sh
COPY scripts/run.sh /usr/local/bin/scripts/run.sh

# Make sure startup scripts are executable
RUN chmod +x /usr/local/bin/scripts/bootstrap/check-services.sh \
             /usr/local/bin/scripts/entrypoints/setup.sh \
             /usr/local/bin/scripts/run.sh

WORKDIR /var/www

# Set the container entrypoint script (runs on container start)
ENTRYPOINT ["/usr/local/bin/scripts/run.sh"]

# Default command left empty, entrypoint will manage execution flow
CMD []
