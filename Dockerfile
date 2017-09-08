FROM php:5.5-apache
RUN pear install Mail
RUN pear install pear/Net_SMTP
RUN docker-php-ext-install mysql
COPY src/ /var/www/html/