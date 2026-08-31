FROM php:8.2-cli

WORKDIR /var/www/html
COPY . .

RUN docker-php-ext-install mysqli pdo pdo_mysql

ENV PORT=8080
EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "/var/www/html"]
