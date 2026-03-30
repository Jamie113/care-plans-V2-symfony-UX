FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip libicu-dev \
    && docker-php-ext-install intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

COPY . .

ENV APP_ENV=prod

RUN php bin/console cache:clear
RUN php bin/console assets:install
RUN php bin/console importmap:install
RUN php bin/console tailwind:build --minify
RUN php bin/console asset-map:compile
RUN php bin/console cache:warmup

EXPOSE 8000

CMD php -S 0.0.0.0:${PORT:-8000} -t public/ public/router.php
