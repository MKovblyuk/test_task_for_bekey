FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Install system dependencies for pdo_pgsql
RUN apk add --no-cache postgresql-dev libpq

# Install PHP extensions, configure pgsql before installation
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/include/postgresql && \
    docker-php-ext-install pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer