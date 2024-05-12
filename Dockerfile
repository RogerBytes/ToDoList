FROM php:8.2-apache

RUN apt update && apt upgrade -y \
  && apt install -y libfreetype6-dev libcurl4-openssl-dev pkg-config libssl-dev nala nano \
  && docker-php-ext-configure gd --with-freetype=/usr/include/freetype2/ \
  && docker-php-ext-install pdo_mysql gd \
  && a2enmod rewrite

COPY ./todolist-app/ /var/www/html

EXPOSE 80
