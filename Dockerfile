FROM php:apache

RUN docker-php-ext-install mysqli

# mysqli extension, which allows the php script to interact with a MySQL database.
