FROM php:8.2-apache

COPY app/ /var/www/html/

RUN mkdir -p /home/carlos \
    && echo "LAB_SECRET_123456789" > /home/carlos/secret \
    && chmod 644 /home/carlos/secret \
    && chmod -R 777 /var/www/html/uploads

EXPOSE 80