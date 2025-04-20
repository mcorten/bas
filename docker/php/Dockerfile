FROM php:8.4-fpm

RUN apt update

# needed to do a composer install
RUN apt-get --yes install zip

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable mysqli
