FROM php:8.3-apache

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_mysql intl

# Install xdebug
RUN pecl install xdebug-3.3.1 && \
    docker-php-ext-enable xdebug

# Install MySQL client
RUN apt-get update && apt-get install -y default-mysql-client


## install composer ########
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

## install node and npm ####
#RUN apt update && apt install -yqq nodejs npm

## Copy actual directory (application in www directory)
COPY . /var/www/

## Modify default  apache conf
COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf

## Modify xdebug conf
COPY ./docker/php/xdebug.ini   /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

#RUN cd /var/www && \
#    composer install

## assign the work directory
WORKDIR /var/www/

#ENTRYPOINT ["bash", "./docker/docker.sh"]

## assign the port to access application
EXPOSE 80