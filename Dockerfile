FROM php:7.0-apache
RUN apt-get update && \
	apt-get install -y mysql-client && \
    apt-get clean
COPY tawi /var/www/html/