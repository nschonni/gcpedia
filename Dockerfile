FROM ubuntu:16.04

RUN apt-get update && apt-get install -y \
    apache2 \
    libapache2-mod-php7.0 \
    php7.0 \
    php7.0-gd \
    php7.0-intl \
    php7.0-mbstring \
    php7.0-mysql \
    php7.0-curl \
    php7.0-xml

WORKDIR /var/www/html

CMD curl -s https://getcomposer.org/installer | php && apache2ctl -D FOREGROUND
