# Use an official PHP image with 8.1 version as the base image
FROM php:8.2

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    curl \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory in the container
WORKDIR /var/www/html

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd

# Enable PHP extension (optional, based on your project requirements)
# RUN docker-php-ext-enable <extension-name>

# Copy composer.json and composer.lock to the working directory
COPY composer.json composer.lock ./

# Install project dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application code
COPY . .

# Generate optimized Composer autoloader
RUN composer dump-autoload --optimize

# Set the appropriate permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 for the web server
EXPOSE 80

# CMD specifies the command to run on container start
CMD ["bash", "./run.sh"]
