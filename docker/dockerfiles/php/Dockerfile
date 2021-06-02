FROM php:7.4-apache
# COPY .. /var/www/html
# RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
# RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN docker-php-ext-install mysqli
RUN apachectl restart
EXPOSE 80