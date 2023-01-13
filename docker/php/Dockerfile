FROM php:8.1-fpm-alpine

ARG user
ARG uid

RUN mkdir -p /var/www/

WORKDIR /var/www/

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN addgroup -g ${uid} --system ${user}
RUN adduser -G ${user} --system -D -s /bin/sh -u ${uid} ${user}

RUN sed -i "s/user = www-data/user = worker/g" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i "s/group = www-data/group = worker/g" /usr/local/etc/php-fpm.d/www.conf

RUN apk update && \
    apk add libpq-dev freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev libwebp-dev \
        libzip-dev zip && \
    docker-php-ext-install pdo pdo_pgsql pgsql zip && \
    docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
    docker-php-ext-install -j$(nproc) gd

USER ${user}
