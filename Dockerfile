# Used for prod build.
FROM php:8.3-fpm as php

# Set environment variables
ENV PHP_OPCACHE_ENABLE=1
ENV PHP_OPCACHE_ENABLE_CLI=0
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0
ENV PHP_OPCACHE_REVALIDATE_FREQ=0

# Install dependencies.
RUN apt-get update && apt-get install -y unzip libpq-dev libcurl4-gnutls-dev nginx libonig-dev zlib1g-dev libpng-dev libxml2-dev curl libjpeg-dev libfreetype6-dev libzip-dev
# Install PHP extensions.
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-configure zip
RUN docker-php-ext-install mysqli pdo pdo_mysql bcmath curl opcache mbstring gd zip mbstring xml
# Clear cache.
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
# Copy composer executable.
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer


# Set working directory to /var/www.
WORKDIR /var/www

# Copy files from current folder to container current folder (set in workdir).
COPY --chown=www-data:www-data . /var/www

RUN cp ./docker/php/php.ini /usr/local/etc/php/php.ini
RUN cp ./docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
RUN cp ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
# remove composer.lock
RUN rm -rf composer.lock
# remove vendor folder
RUN rm -rf ./vendor

# install composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# run composer dump-autoload
RUN composer dump-autoload

#cp .env.example .env
RUN cp .env.example .env
RUN php artisan key:generate
#cp tts_erp_dev database

# Create laravel caching folders.
RUN mkdir -p /var/www/storage/framework
RUN mkdir -p /var/www/storage/framework/cache
RUN mkdir -p /var/www/storage/framework/testing
RUN mkdir -p /var/www/storage/framework/sessions
RUN mkdir -p /var/www/storage/framework/views

# Fix files ownership.
RUN chown -R www-data:www-data /var/www/storage
RUN chown -R www-data:www-data /var/www/storage/framework
RUN chown -R www-data:www-data /var/www/storage/framework/sessions

# Set correct permission.
RUN chmod -R 755 /var/www/storage
RUN chmod -R 755 /var/www/storage/logs
RUN chmod -R 755 /var/www/storage/framework
RUN chmod -R 755 /var/www/storage/framework/sessions
RUN chmod -R 755 /var/www/bootstrap
# Adjust user permission & group
RUN usermod --uid 1000 www-data
RUN groupmod --gid 1001 www-data
RUN chmod +x /var/www/entrypoint.sh
# Set correct permission.
RUN chown -R www-data:www-data /var/www

USER $user
# Run the entrypoint file.
ENTRYPOINT ["/var/www/entrypoint.sh"]
