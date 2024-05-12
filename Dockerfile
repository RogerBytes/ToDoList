FROM php:8.2-apache
RUN apt update && apt upgrade \
  && apt install -y libfreetype6-dev libcurl4-openssl-dev pkg-config libssl-dev nala nano\
  && docker-php-ext-configure gd --with-freetype=/usr/include/freetype2/ \
  && docker-php-ext-install pdo_mysql gd \
  && a2enmod rewrite

RUN pecl install mongodb && docker-php-ext-enable mongodb \
&& echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/ext-mongodb.ini
RUN a2enmod rewrite
# COPY . /var/www/html
EXPOSE 80