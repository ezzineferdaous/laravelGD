# Use the official PHP 8.3 image with Apache
FROM php:8.3-apache

# Set the working directory
WORKDIR /var/www/html

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy your application files from the host into the container
COPY . /var/www/html

# Copy the custom Apache configuration file
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# Set permissions for the application files
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache in the foreground
CMD ["echo","custom image  vs"]
