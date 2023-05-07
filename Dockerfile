FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    unzip

# Install required extensions
RUN docker-php-ext-install pdo pdo_mysql

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


# Expose port 9000
EXPOSE 9000
