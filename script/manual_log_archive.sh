#!/bin/bash

DATE=$1
TIME=`date +-%H%M%S`

#日志路径
PHPSTUDY=/phpstudy/www/yii2/log
NORMAL=/opt/logs/normal
DEBUG=/opt/logs/debug
PHP=/opt/logs/php
NGINX=/opt/logs/nginx

#phpstudy日志分割
PHPSTUDY_FILE="error_log-$DATE.log normal_info-$DATE.log"

if [ ! -d "$PHPSTUDY/archive/$DATE" ]; then
    mkdir -p $PHPSTUDY/archive/$DATE
fi

for FILE in $PHPSTUDY_FILE
do
    cd $PHPSTUDY/archive/$DATE
    if [ -f "$PHPSTUDY/$FILE" ]; then
        cp $PHPSTUDY/$FILE $PHPSTUDY/archive/$DATE
        echo "" > $PHPSTUDY/$FILE
        tar -jcf $FILE$TIME.tar.bz2 $FILE
        rm -r $FILE
    fi
done

#normal日志分割
NORMAL_FILE="error_log-$DATE.log normal_info-$DATE.log"

if [ ! -d "$NORMAL/archive/$DATE" ]; then
    mkdir -p $NORMAL/archive/$DATE
fi

for FILE in $NORMAL_FILE
do
    cd $NORMAL/archive/$DATE
    if [ -f "$NORMAL/$FILE" ]; then
        cp $NORMAL/$FILE $NORMAL/archive/$DATE
        echo "" > $NORMAL/$FILE
        tar -jcf $FILE$TIME.tar.bz2 $FILE
        rm -r $FILE
    fi
done

#debug日志分割
DEBUG_FILE="error_log-$DATE.log normal_info-$DATE.log L_train-$DATE.log L_user-$DATE.log TrainController-$DATE.log UserController-$DATE.log SiteController-$DATE.log GradeinfoController-$DATE.log SysinfoController-$DATE.log TripmessageController-$DATE.log"

if [ ! -d "$DEBUG/archive/$DATE" ]; then
    mkdir -p $DEBUG/archive/$DATE
fi

for FILE in $DEBUG_FILE
do
    cd $DEBUG/archive/$DATE
    if [ -f "$DEBUG/$FILE" ]; then
        cp $DEBUG/$FILE $DEBUG/archive/$DATE
        echo "" > $DEBUG/$FILE
        tar -jcf $FILE$TIME.tar.bz2 $FILE
        rm -r $FILE
    fi
done

#php日志分割
PHP_FILE="php_errors.log"

if [ ! -d "$PHP/archive/$DATE" ]; then
    mkdir -p $PHP/archive/$DATE
fi

for FILE in $PHP_FILE
do
    cd $PHP/archive/$DATE
    if [ -f "$PHP/$FILE" ]; then
        cp $PHP/$FILE $PHP/archive/$DATE
        echo "" > $PHP/$FILE
        tar -jcf $FILE$TIME.tar.bz2 $FILE
        rm -r $FILE
    fi
done

#nginx日志分割
NGINX_FILE="access.log error.log host-8082.access.log host-8083.access.log host-80.access.log"

if [ ! -d "$NGINX/archive/$DATE" ]; then
    mkdir -p $NGINX/archive/$DATE
fi

for FILE in $NGINX_FILE
do
    cd $NGINX/archive/$DATE
    if [ -f "$NGINX/$FILE" ]; then
        cp $NGINX/$FILE $NGINX/archive/$DATE
        echo "" > $NGINX/$FILE
        tar -jcf $FILE$TIME.tar.bz2 $FILE
        rm -r $FILE
    fi
done

