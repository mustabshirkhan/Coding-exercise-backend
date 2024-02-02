FROM php:8.1.0-fpm

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Copy the example environment file

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 777 /var/www/html/


# Install application dependencies
RUN composer install --no-interaction --optimize-autoloader
RUN composer require league/oauth2-server
RUN composer require laravel/passport


# Generate application key
RUN php artisan key:generate
RUN php artisan config:clear

#RUN php artisan migrate
# Expose port
EXPOSE 9000

# Run the application
CMD php artisan serve --host=0.0.0.0 --port=9000
