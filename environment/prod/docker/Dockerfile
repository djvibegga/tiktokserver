FROM alpine:3.6
RUN apk update && apk upgrade

#install devops sortware
RUN apk add htop nmap git curl nano bash

#install java
RUN apk --update add openjdk7-jre

#install python3
RUN apk add --update python3

#install nginx
RUN apk add nginx

#install php+fpm
ENV PHP_VERSION 7
RUN apk add \
    php${PHP_VERSION} \
    php${PHP_VERSION}-fpm \
    php${PHP_VERSION}-opcache
    
RUN apk add \
    php${PHP_VERSION}-pdo \
    php${PHP_VERSION}-pgsql \
    php${PHP_VERSION}-pdo_pgsql \
    php${PHP_VERSION}-zlib \
    php${PHP_VERSION}-curl \
    php${PHP_VERSION}-xml \
    php${PHP_VERSION}-memcached \
    php${PHP_VERSION}-imagick \
    php${PHP_VERSION}-json \
    php${PHP_VERSION}-gd \
    php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-pcntl \
    php${PHP_VERSION}-posix \
    php${PHP_VERSION}-mcrypt \
    php${PHP_VERSION}-openssl \
    php${PHP_VERSION}-ctype \
    php${PHP_VERSION}-dom \
    php${PHP_VERSION}-phar \ 
    php${PHP_VERSION}-xmlwriter \
    php${PHP_VERSION}-tokenizer \
    php${PHP_VERSION}-fileinfo \
    php${PHP_VERSION}-zip

#install memcached
RUN apk add memcached

#install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --filename=composer --install-dir=/bin
RUN php -r "unlink('composer-setup.php');"

#install chared (detection of encoding)
COPY chared-2.0.tar.gz /tmp/chared-2.0.tar.gz
RUN cd /tmp && tar xzvf chared-2.0.tar.gz && cd chared-2.0/ && python3 setup.py install && rm -rf /tmp/chared-2.0.tar.gz && rm -rf /tmp/chared-2.0

#install FFMPEG library
RUN apk add ffmpeg

#copy configuration files inside the system
COPY docker-entrypoint.sh /
RUN chmod a+x /docker-entrypoint.sh

#open ports outside
EXPOSE 80
EXPOSE 443

#entry point
CMD ["/docker-entrypoint.sh"]
