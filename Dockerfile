FROM php:7.0-apache
RUN apt-get update && \
	apt-get install mysql-client && \
    apt-get clean
COPY tawi /var/www/html/