FROM golang:1.15 AS builder
RUN go get -d -v github.com/mailhog/mhsendmail \
  && cd /go/src/github.com/mailhog/mhsendmail/ \
  && GOOS=linux GOARCH=arm64 go build -o mhsendmail .

FROM php:7.4.7-fpm
WORKDIR /var/www/html
RUN apt-get update \
  && docker-php-ext-install pdo_mysql

COPY --from=builder /go/src/github.com/mailhog/mhsendmail/mhsendmail /usr/local/bin/
RUN chmod +x /usr/local/bin/mhsendmail
COPY ./php.ini /usr/local/etc/php/
# composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
# git
RUN apt-get install -y git
