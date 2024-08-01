#!/bin/bash

php artisan migrate

php-fpm -D
nginx -g "daemon off;"


exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf