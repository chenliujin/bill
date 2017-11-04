#!/bin/bash

version=1.0.0-alpha.1

docker build -t registry.iot-sw.net:5000/bill-tps-requester:$version \
	-f ~/bill_v1/03-source/bill.work/tps.requester/Dockerfile.sandbox ~	 

docker push registry.iot-sw.net:5000/bill-tps-requester:$version


