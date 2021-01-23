FROM php:8.0.1-cli-buster

RUN apt-get update && apt-get install -y \
        nano \
        wget \
        git \
        zlib1g-dev \
        libzip-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

RUN docker-php-ext-install \
    zip \
    bcmath \
    exif 

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /usr/src/biblionet