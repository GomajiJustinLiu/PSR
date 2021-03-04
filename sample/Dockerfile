FROM php:7.4-alpine3.12

RUN apk update && apk upgrade && \
    apk --no-cache --progress add \
    composer

WORKDIR /var/www/html