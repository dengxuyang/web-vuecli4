FROM php:5.6-apache

MAINTAINER winyeahs

RUN apt-get update

RUN apt-get install -y libwebp-dev libfreetype6-dev libmcrypt-dev libjpeg-dev libpng-dev zlib1g-dev

RUN docker-php-ext-configure gd --with-webp-dir=/usr/include/webp --with-jpeg-dir=/usr/include --with-png-dir=/usr/include --with-freetype-dir=/usr/include/freetype2

# RUN docker-php-ext-install mbstring

# RUN docker-php-ext-install zip

RUN docker-php-ext-install gd

RUN docker-php-ext-install mysql

COPY . /var/www/html


RUN chmod -R 777 /var/www/html/back/gthmmc/template_c/
RUN chmod -R 777 /var/www/html/back/site
RUN chmod -R 777 /var/www/html/back/mediaLibrary
RUN chmod -R 777 /var/www/html/back/gthmmc/plugin/
RUN chmod -R 777 /var/www/html/back/gthmmc/cache/

RUN service apache2 restart


# CMD ["./run.sh"]