FROM php:8.2-apache

RUN mkdir -p /home/carlos && \
    echo "LAB_SECRET_12345" > /home/carlos/secret

RUN mkdir -p /var/www/html/uploads

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html/uploads

EXPOSE 80