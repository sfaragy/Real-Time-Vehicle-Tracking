FROM php:8.3-fpm
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
    git \
    cron \
    nano \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

# Install MongoDB PHP extension
#RUN pecl install mongodb \
#    && docker-php-ext-enable mongodb \

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN pecl install redis \
    && docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./lmw/ .

#RUN composer dump-autoload -o \
#    && chown -R :www-data /var/www/html \
#    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \

RUN composer install

COPY ./docker/scheduler/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

EXPOSE 9000

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]




ENV EDITOR=nano