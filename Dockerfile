FROM php:7.1-fpm

MAINTAINER Andrew Sparrow <a.vorobyev@mildberry.com>

#####################################
# Non-Root User Codenetix:
#####################################
RUN groupadd -g 1000 codenetix && \
    useradd -u 1000 -g codenetix -m codenetix

#####################################
# APT-GET:
#####################################
RUN curl -sL https://deb.nodesource.com/setup_6.x | bash -

RUN apt-key adv --keyserver hkp://pgp.mit.edu:80 --recv-keys 573BFD6B3D8FBC641079A6ABABF5BD827BD9BF62 \
        && echo "deb http://nginx.org/packages/debian/ jessie nginx" >> /etc/apt/sources.list \
        && apt-get update \
        && apt-get install --no-install-recommends --no-install-suggests -y \
        ca-certificates \
        nginx \
        git \
        ssh \
        libjpeg-dev \
        libpng12-dev \
        libfreetype6-dev \
        libmcrypt-dev \
        nano

RUN apt-get clean

RUN docker-php-ext-install -j$(nproc) iconv zip mcrypt pdo mysqli pdo_mysql \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && curl https://getcomposer.org/composer.phar > /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

#####################################
# xDebug:
#####################################
ARG INSTALL_XDEBUG=false
ENV INSTALL_XDEBUG ${INSTALL_XDEBUG}
RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    pecl install xdebug && \
    docker-php-ext-enable xdebug \
;fi

ARG XDEBUG_REMOTE_HOST=""
ENV XDEBUG_REMOTE_HOST ${XDEBUG_REMOTE_HOST}

###################################
# App files:
#####################################
WORKDIR /var/www/
ADD . /var/www/
RUN rm -rf /var/www/container

######################################
## Container files:
######################################
ADD ./container /container

#####################################
# RSA ssh
#####################################
ADD ./container/rsa/ /root/.ssh/
RUN cp /container/rsa/* /root/.ssh/ && \
    chmod 600 /root/.ssh/id_rsa && \
    echo "Host git.codenetix.com\n\tStrictHostKeyChecking no\n" >> /root/.ssh/config

#####################################
# PHP-FPM conf
#####################################
RUN php /container/templates/php.ini.php > /usr/local/etc/php/conf.d/php.ini && \
    rm /usr/local/etc/php-fpm.d/www.conf && \
    cp /container/config/php.pool.conf /usr/local/etc/php-fpm.d/php.pool.conf

#####################################
# NGINX conf
#####################################
RUN cp /container/config/nginx.conf /etc/nginx/nginx.conf && \
    cp /container/config/server_defaults.conf /etc/nginx/server_defaults.conf && \
    cp /container/config/laravel.conf /etc/nginx/conf.d/laravel.conf && \
    rm /etc/nginx/conf.d/default.conf

#####################################
# Composer install
#####################################
ARG COMPOSER_INSTALL_RUN=true
ENV COMPOSER_INSTALL_RUN ${COMPOSER_INSTALL_RUN}
RUN if [ ${COMPOSER_INSTALL_RUN} = true ]; then \
composer install && composer dump-autoload \
;fi

#####################################
# App files permissions & Clean up and ready to go:
#####################################
RUN find ./ -type d -exec chmod 755 {} + && \
    find ./ -type f -exec chmod 644 {} + && \
    chmod -R ug+rwx ./storage && \
    chown -R codenetix:codenetix ./ && \
    chmod 700 /var/www/bin/run.sh && \
    rm -rf /container && \
    php artisan storage:link

EXPOSE 80 443

ENTRYPOINT ["./bin/run.sh"]
