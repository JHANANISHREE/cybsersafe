# Use official lightweight PHP 8.2 with Apache
FROM php:8.2-apache

# Install PDO MySQL driver
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache URL rewrite engine
RUN a2enmod rewrite

# Set working directory to Apache document root
WORKDIR /var/www/html

# Copy all website application files
COPY . /var/www/html/

# Expose standard web traffic port
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
