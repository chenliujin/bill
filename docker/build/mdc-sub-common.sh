#!/bin/bash
#
# @author chenliujin <liujin.chen@qq.com>
# @since 2017-05-09
#
if [ -z $DOCKER_BUILD_ROOT ]; then
	export DOCKER_BUILD_ROOT=$HOME
fi 

version=1.0.0-alpha.0

docker build -t registry.iot-sw.net:5000/subscribe/common:$version \
	-f $DOCKER_BUILD_ROOT/subscribe/common/nodejs/Dockerfile.sandbox \
	$DOCKER_BUILD_ROOT/subscribe/common/nodejs/


docker push registry.iot-sw.net:5000/subscribe/common:$version
