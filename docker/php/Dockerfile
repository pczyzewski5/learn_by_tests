FROM php:8.2-fpm
RUN docker-php-ext-install pdo_mysql

# install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# install other soft
RUN apt-get update
RUN apt-get install -y git libzip-dev zip rsync
RUN docker-php-ext-install zip

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
