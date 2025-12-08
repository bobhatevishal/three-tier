FROM php:8.3-fpm

# Install MySQL drivers
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY index.php .

# Expose port 9000 (Internal use only)
EXPOSE 9000
