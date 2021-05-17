#!/bin/sh

export APP_DIR=/var/www/html
export APP_CACHE_DIR=$APP_DIR/cache
export APP_IP_ADDRESS=172.50.1.100
export APP_PORT=80

export MEMCACHED_MEMORY=512M
export MEMCACHED_MAX_CONNECTIONS=1024
export MEMCACHED_MAX_ITEM_SIZE=1M

#run memcached
/usr/bin/memcached -d -u memcached -v -m "${MEMCACHED_MEMORY}" -p 11211 -c "${MEMCACHED_MAX_CONNECTIONS}" -I "${MEMCACHED_MAX_ITEM_SIZE}" > /dev/null 2>&1 &

#Setup cron
crontab /tmp/crontab
/usr/sbin/crond -b -l 0 -L $APP_DIR/runtime/logs/crond.log

#Recreate app directories
mkdir $APP_CACHE_DIR -m 777 -p

#Run background services
cd $APP_DIR && php public/server.php $APP_IP_ADDRESS $APP_PORT > logs/server.log 2>&1 &

while sleep 60; do
  echo "working" > /dev/null
done

exec "$@"
