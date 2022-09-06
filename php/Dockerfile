FROM php:7.4.7-fpm
WORKDIR /var/www/html
RUN apt-get update \
  && docker-php-ext-install pdo_mysql
RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
  && chmod +x mhsendmail \
  && mv mhsendmail /usr/local/bin/mhsendmail
COPY ./php.ini /usr/local/etc/php/
