#!/bin/sh

export APP_DIR=/var/www/html
export APP_CACHE_DIR=$APP_DIR/runtime/cache
export APP_SOC_CACHE_DIR=$APP_DIR/runtime/soc_cache

export MEMCACHED_MEMORY=512M
export MEMCACHED_MAX_CONNECTIONS=1024
export MEMCACHED_MAX_ITEM_SIZE=1M

#run memcached
/usr/bin/memcached -d -u memcached -v -m "${MEMCACHED_MEMORY}" -p 11211 -c "${MEMCACHED_MAX_CONNECTIONS}" -I "${MEMCACHED_MAX_ITEM_SIZE}" > /dev/null 2>&1 &

#run nginx
mkdir /opt/nginxcache/samepost -m 777 -p
mkdir /opt/nginxcache/tmp -m 777 -p
mkdir /run/nginx
/usr/sbin/nginx > /dev/null 2>&1 & "$@"

#run php-fpm
php-fpm7

#Setup cron
crontab /tmp/crontab
/usr/sbin/crond -b -l 0 -L $APP_DIR/runtime/logs/crond.log

#Recreate app directories
mkdir $APP_CACHE_DIR -m 777 -p
mkdir $APP_SOC_CACHE_DIR -m 777 -p

#Run background services
cd /var/www/html && ./yii daemon/restart
cd /var/www/html && ./yii watcher/restart

while sleep 60; do
  echo "working" > /dev/null
done

exec "$@"
