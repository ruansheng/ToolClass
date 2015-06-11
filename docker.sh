#! /bin/bash

function output_result(){
        echo '---------------------------------------------'
        echo
        echo              $1 is OK !
        echo
        echo '---------------------------------------------'
}


if [ "$1" = "" ]; then
        echo 'loss param : start | stop | restart | kill | status '
        exit 0
fi

PID_FILE='./docker_pid/sample.pid'
DOCKER_IMAGE='ruansheng/dev:v4'
PORT='6001:6001'

PRO_PATH='/Users/ruansheng/PhpstormProjects/sample'
PRO_PATH_DOCKER='/root/sample'

NGINX_CONF_PATH='/Users/ruansheng/PhpstormProjects/nginx_conf'
NGINX_CONF_PATH_DOCKER='/root/nginx_conf'

case $1 in
        start)

                # pid 文件存在，并且非空
                if [ -s $PID_FILE ]; then
                        PID=`cat $PID_FILE`
                        short_pid=${PID:0:12}
                        count_run=`docker ps | grep $short_pid | wc -l`
                        if [ $count_run = 1 ]; then
                                echo 'this docker container is running...'
                                exit 0
                        else
                                count_exists=`docker ps -a | grep $short_pid | wc -l`
                                if [ $count_exists = 1 ]; then
                                        docker start $PID
                                else
                                        PID=`docker run -d -i -p $PORT -v $PRO_PATH:$PRO_PATH_DOCKER -v $NGINX_CONF_PATH:$NGINX_CONF_PATH_DOCKER $DOCKER_IMAGE`
                                        echo $PID > $PID_FILE
                                fi
                        fi
                else
                        PID=`docker run -d -i -p $PORT -v $PRO_PATH:$PRO_PATH_DOCKER -v $NGINX_CONF_PATH:$NGINX_CONF_PATH_DOCKER $DOCKER_IMAGE`
                        echo $PID > $PID_FILE
                fi

                PID=`cat $PID_FILE`
                short_pid=${PID:0:12}
                docker exec $short_pid /usr/local/nginx/sbin/nginx
                docker exec $short_pid /usr/local/php/sbin/start.sh
        ;;
        stop)
                PID=`cat $PID_FILE`
                short_pid=${PID:0:12}
                if [ "$short_pid" = "" ]; then
                        echo 'this container is not exists '
                        exit 0
                else
                        docker stop $short_pid
                fi
        ;;
        restart)
                echo 'restart'
                exit 0
        ;;
        kill)
                PID=`cat $PID_FILE`
                short_pid=${PID:0:12}
                if [ "$short_pid" = "" ]; then
                        echo 'this container pid is not exists '
                        exit 0
                else
                        docker kill $short_pid
                fi
        ;;
        status)
                echo 'status'
                exit 0
        ;;
        *)
                echo not found $1 param
                exit 0
        ;;
esac

output_result $1
