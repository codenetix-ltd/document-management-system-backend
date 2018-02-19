#!/usr/bin/env bash

test -e /var/log/xdebug.log && chown codenetix:codenetix /var/log/xdebug.log
test -e /var/www/storage/app && chown -R codenetix:1000 /var/www/storage/app


exec "$@"

php-fpm --daemonize
nginx