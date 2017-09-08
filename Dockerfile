FROM php:5.5-apache
RUN pear install Mail
RUN docker-php-ext-install mysql
COPY src/ /var/www/html/