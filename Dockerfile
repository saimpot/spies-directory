FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y libpng-dev libjpeg62-turbo-dev libfreetype6-dev locales zip git unzip libzip-dev libonig-dev && rm -rf /var/lib/apt/lists/*

# Set locale to en_US.UTF-8
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen

# Install extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd pdo pdo_mysql mbstring zip exif pcntl bcmath

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www/

# Install Laravel dependencies
RUN composer install
