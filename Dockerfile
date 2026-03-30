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

RUN APP_ENV=prod composer run-script post-install-cmd --no-interaction

EXPOSE 8000

CMD php -S 0.0.0.0:${PORT:-8000} -t public/
