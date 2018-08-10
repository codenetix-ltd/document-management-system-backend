#!/usr/bin/env bash

if [ "$APP_ENV" = "local" ];
then
    composer install
    php artisan dms:create-test-database
fi

php artisan migrate
php artisan db:seed
php artisan dms:passport-init