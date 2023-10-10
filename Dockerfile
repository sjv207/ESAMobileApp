FROM php:8-apache

RUN apt update
RUN apt install -y nodejs && docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

COPY src/ /var/www/html/
WORKDIR /var/www/html

EXPOSE 80
