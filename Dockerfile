FROM php:8.2-fpm

RUN apt-get update &&\
    apt-get install -y --no-install-recommends zip unzip git ssh-client curl

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /code
