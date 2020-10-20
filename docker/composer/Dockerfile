FROM php:7.3-cli

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update
#RUN apt-get install zip unzip

RUN apt-get install -y libzip-dev zlib1g-dev
RUN docker-php-ext-install zip
