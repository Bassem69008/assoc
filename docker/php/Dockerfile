FROM php:8.3-apache

# Add the install-php-extensions script
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql intl zip

# Install xdebug
RUN pecl install xdebug-3.3.1 && \
    docker-php-ext-enable xdebug

# Install MySQL client and other dependencies
RUN apt-get update && apt-get install -y unzip default-mysql-client

# Install Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm composer-setup.php

# Set Composer to prefer dist packages
RUN composer config --global preferred-install dist

# Optional: Install Node and npm if needed
# RUN apt update && apt install -yqq nodejs npm

# Copy application files
COPY . /var/www/

# Change owner to www-data
RUN chown -R www-data:www-data /var/www/

# Modify default Apache configuration
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Modify xdebug configuration
COPY ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Set the working directory
WORKDIR /var/www/

# Expose port 80
EXPOSE 80
