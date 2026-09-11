FROM php:8.2-apache

RUN mkdir -p /var/www/html/files \
    && chown -R www-data:www-data /var/www/html/files

RUN mkdir -p /home/carlos \
    && echo "LAB_SECRET_123456" > /home/carlos/secret \
    && chown www-data:www-data /home/carlos/secret