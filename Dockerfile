FROM codenetix/laravel-dms-backend-platform:latest
MAINTAINER Vladimir Barnitun <vbarmotin@codenetix.com>

COPY ./composer.* /var/www/
COPY ./database /var/www/database

RUN composer install --no-dev && rm -rf /root/.composer

COPY ./artisan /var/www/
COPY ./bootstrap /var/www/bootstrap
COPY ./public /var/www/public
COPY ./storage /var/www/storage
COPY ./config /var/www/config
COPY ./resources /var/www/resources
COPY ./routes /var/www/routes
COPY ./app /var/www/app

RUN chown -R www-data:www-data /var/www

EXPOSE 80

CMD ["/usr/sbin/run.sh"]