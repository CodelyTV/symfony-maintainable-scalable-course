FROM php:8.0-fpm

WORKDIR /app

RUN apt update \
    && apt install -y libicu-dev libzip-dev \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        opcache \
        intl \
        zip \
        pdo_mysql

RUN apt install -y git

RUN docker-php-ext-enable \
        opcache

RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony
