FROM php:7.0-apache
RUN apt-get update && \
	docker-php-ext-install mysqli && docker-php-ext-enable mysqli && \
    apt-get clean
COPY tawi /var/www/html/