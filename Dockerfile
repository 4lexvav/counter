FROM php:7.2.30-apache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html/

RUN rm -rf /var/www/html/*
COPY counter/ /var/www/html/

RUN composer install --no-dev --prefer-dist --optimize-autoloader && \
    composer clear-cache

# Set www as owner
RUN chown -R www-data:www-data /var/www

EXPOSE 80