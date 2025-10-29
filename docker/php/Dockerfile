FROM php:8.2-fpm

# Установим системные пакеты и mysql client
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Устанавливаем нужные расширения PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Установим composer (копируем из официального образа)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
