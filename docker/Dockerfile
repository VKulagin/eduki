FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    librabbitmq-dev \
    pkg-config \
    && docker-php-ext-install pdo pdo_pgsql \
    && pecl install amqp \
    && pecl install xdebug \
    && docker-php-ext-enable amqp \
    && docker-php-ext-enable xdebug \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY docker/xdebug.ini /usr/local/etc/php/conf.d/99-xdebug.ini

WORKDIR /app
COPY . /app

RUN php -m | grep amqp
RUN php -m | grep xdebug
RUN composer install

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
