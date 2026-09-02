FROM php:8.2-apache

RUN mkdir -p /var/www/html/files/avatars
RUN mkdir -p /home/carlos

RUN echo "LAB_SECRET_123456789" > /home/carlos/secret

RUN chown -R www-data:www-data /var/www/html/files

WORKDIR /var/www/html

EXPOSE 80