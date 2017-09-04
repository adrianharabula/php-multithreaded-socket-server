FROM php:7.1
LABEL maintainer="adrian.harabula@toss.ro"

RUN docker-php-ext-install pcntl sockets

COPY . /var/www/html
WORKDIR /var/www/html

CMD [ "php", "./server.php" ]

EXPOSE 80