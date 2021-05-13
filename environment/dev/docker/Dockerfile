FROM alpine:3.6
RUN apk update && apk upgrade

#install devops sortware
RUN apk add htop nmap git curl nano bash

#install php7 & extensions
ENV PHP_VERSION 7
RUN apk add \
    php${PHP_VERSION} \
    php${PHP_VERSION}-opcache
    
RUN apk add \
    php${PHP_VERSION}-zlib \
    php${PHP_VERSION}-curl \
    php${PHP_VERSION}-xml \
    php${PHP_VERSION}-openssl \
    php${PHP_VERSION}-memcached \
    php${PHP_VERSION}-json \
    php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-ctype \
    php${PHP_VERSION}-xdebug \
    php${PHP_VERSION}-dom \
    php${PHP_VERSION}-phar \
    php${PHP_VERSION}-fileinfo \
    php${PHP_VERSION}-sockets

#install memcached
RUN apk add memcached

#install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --filename=composer --install-dir=/bin
RUN php -r "unlink('composer-setup.php');"

#copy configuration files inside the system
COPY docker-entrypoint.sh /
RUN chmod a+x /docker-entrypoint.sh

#open ports outside
EXPOSE 80

#entry point
CMD ["/docker-entrypoint.sh"]
