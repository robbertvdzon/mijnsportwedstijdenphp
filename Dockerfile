FROM php:5.5-apache
RUN pear install Mail
#RUN docker-php-ext-install pdo pdo_mysql zip

COPY src/ /var/www/html/