#!/bin/bash

version=1.0.0-alpha.1

docker build -t registry.iot-sw.net:5000/mdc/notifier:$version \
	-f ~/notifying/nodejs/Dockerfile.sandbox ~/notifying/nodejs/
