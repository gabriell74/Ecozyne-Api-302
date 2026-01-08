FROM php:8.3-fpm-alpine

# Install dependencies
RUN apk add --no-cache \
    bash \
    zip \
    unzip \
    git \
    curl \
    icu-dev \
    oniguruma-dev \
    openssl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev

# Configure GD BEFORE installing it
RUN docker-php-ext-configure gd \
    --with-freetype=/usr/include/ \
    --with-jpeg=/usr/include/

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    mbstring \
    intl \
    gd

# Fix permission user
RUN apk add --no-cache shadow \
    && usermod -u 1000 www-data \
    && groupmod -g 1000 www-data

WORKDIR /var/www/html

# Copy semua file Laravel
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Default command
CMD ["php-fpm"]