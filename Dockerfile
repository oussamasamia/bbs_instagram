FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    unzip \
    apache2 \
    apache2-utils \
    libapache2-mod-php8.1

# Enable Apache mods
RUN a2enmod rewrite

# Install required extensions
RUN docker-php-ext-install pdo pdo_mysql gd mbstring exif pcntl bcmath


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#set our application folder as an environment variable
ENV APP_HOME /var/www/html

# Copy source files
COPY . $APP_HOME


# Install the required packages
RUN composer install --optimize-autoloader  --no-dev  --prefer-dist


# Clear cache
RUN php artisan cache:clear
RUN php artisan route:clear
RUN php artisan config:clear
RUN php artisan view:clear
RUN php artisan optimize:clear
RUN php artisan storage:link


# Change ownership of our applications
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/*


# Expose port 80
EXPOSE 80
