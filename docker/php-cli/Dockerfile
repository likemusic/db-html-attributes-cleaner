FROM php:7.3-cli

# RUN apt-get update

# RUN docker-php-ext-install mysqli

#RUN apt-get install -y libmcrypt-dev
#RUN pecl install mcrypt-1.0.2

#RUN apt-get install -y libfreetype6-dev \
#        libjpeg62-turbo-dev \
#        libpng-dev

#RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
#RUN docker-php-ext-install -j$(nproc) gd

#RUN docker-php-ext-install gd

RUN pecl install xdebug-2.9.7 \
    && docker-php-ext-enable xdebug
