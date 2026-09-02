FROM php:8.2-apache

WORKDIR /var/www/html

COPY . .

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite

ENV PORT=8080

EXPOSE 8080

CMD sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf && \
    sed -i "s/:80>/:${PORT}>/g" /etc/apache2/sites-available/000-default.conf && \
    apache2-foreground
