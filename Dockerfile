# Use PHP with Apache
FROM php:8.2-apache

# Copy project files
COPY . /var/www/html/

# Install composer (optional)
RUN apt-get update && apt-get install -y unzip git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html
