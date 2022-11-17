#Arquivo de configuração da imagem docker e de pré configurações dos containeres.
FROM php:8.1.0-fpm-alpine3.14

RUN touch ./setup.sql
RUN echo "DB_NAME varchar := ${DB_DATABASE} SELECT 'CREATE DATABASE DB_NAME' WHERE NOT EXISTS (SELECT FROM pg_database  WHERE datname = DB_NAME)\gexec" > setup.sql



RUN apk add --no-cache openssl bash nodejs npm postgresql-dev
RUN docker-php-ext-install bcmath pdo pdo_pgsql

WORKDIR /var/www

RUN rm -rf /var/www/html
RUN ln -s public html


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www

RUN chmod -R 777 /var/www/storage

EXPOSE 9000

ENTRYPOINT [ "php-fpm" ]