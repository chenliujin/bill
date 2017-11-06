# 票券微服务沙盒环境API接口命令集合
## 设置初始化变量

~~~js

$publisherId = 10000;  //发行商户编号

$finalAcceptorId = 10001; //最终承兑商户编号

$resalerId = 10002; // 普通分发商户编号

$acceptorId = 10003; //普通承兑商户编号

$customerId = 10004; //顾客(持有人)编号

$transfereeId = 10005; //转让(受让人)顾客编号

~~~

## 开始申请一个新的发行
**原始API:**

~~~js
https://sandbox.iot-sw.net/bill/v1/publisher/:publisherId/bill

POST
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100"}' https://sandbox.iot-sw.net/bill/v1/publisher/10000/bill

~~~

## 更新票券发行期的基础数据:
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/publisher/:publisherId/bill/:billId

PUT
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","billFacadeLabelTemplate":"test label Templace","billFacadeTitle":"Bill demo 2","billFacadeDetail":"just a demo","billFacadeLogo":"http:\/\/images.iot-sw.com\/images\/logo\/bill\/test.png","billFacadeMoreLink":"http:\/\/more.iot-sw.com\/links\/more\/test.html","billDistributionAmount":"1000","billDistributionStart":"2017-04-20 22:00:00","billDistributionEnd":"2017-08-17 23:59:59","billAcceptanceTimeType":"1","billAcceptanceFixRangeStart":"2017-04-20 22:00:00","billAcceptanceFixRangeEnd":"2018-04-18 23:59:59"}' https://sandbox.iot-sw.net/bill/v1/publisher/10000/bill/3

~~~

## 添加票券发行期的可兑换项目数据:
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/publisher/:publisherId/bill/:billId/value

POST
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","valueSort":"1","valueType":"Games","valueSubType":"temp","valueUnit":"\u6b21","valueQty":"1","valueCodeList":["fly_birds"]}' https://sandbox.iot-sw.net/bill/v1/publisher/10000/bill/3/value

~~~

## 设置票券发行期的最终承兑商数据:
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/publisher/:publisherId/bill/:billId/finalAcceptor

PUT
~~~


**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","finalAcceptorId":"10001","finalAcceptorType":"2","finalAcceptorName":"\u597d\u53c8\u591a\u7efc\u5408\u8d85\u5e02","finalAcceptorLogo":"http:\/\/images.iot-sw.net\/images\/logo\/test.png"}' https://sandbox.iot-sw.net/bill/v1/publisher/10000/bill/3/finalAcceptor
~~~

## 添加票券发行期的普通承兑商数据:
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/publisher/:publisherId/bill/:billId/acceptor

POST
~~~


**Curl demo:**


~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","acceptorId":"10002","acceptorType":"1","acceptorName":"\u597d\u53c8\u591a\u897f\u4e3d\u5e97","acceptorLogo":"http:\/\/images.iot-sw.net\/images\/logo\/test.png","acceptQty":"500"}' https://sandbox.iot-sw.net/bill/v1/publisher/10000/bill/3/acceptor
~~~

## 添加票券发行期的普通分发商数据:
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/publisher/:publisherId/bill/:billId/resaler

POST
~~~


**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","resalerId":10002,"resalerType":"1","resalerName":"\u897f\u4e3d\u8089\u83dc\u7efc\u5408\u5e02\u573a","resalerLogo":"http:\/\/images.iot-sw.net\/images\/logo\/test.png","resalerQty":"500"}' https://sandbox.iot-sw.net/bill/v1/publisher/10000/bill/3/resaler

~~~

## 获取票券列表数据
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/publisher/:publisherId/bill/:billId

GET
~~~


**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","keyword":"Bill demo","billStatus":["2"]}' https://sandbox.iot-sw.net/bill/v1/publisher/10000/bill
~~~


## 获取票券可兑换项目列表数据
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/publisher/:publisherId/bill/:billId/value

GET
~~~


**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100"}' https://sandbox.iot-sw.net/bill/v1/publisher/10000/bill/3/value
~~~

## 获取票券的普通承兑商列表数据
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/publisher/:publisherId/bill/:billId/acceptor

GET
~~~


**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100"}' https://sandbox.iot-sw.net/bill/v1/publisher/10000/bill/3/acceptor
~~~

## 获取票券的普通分发商列表数据
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/publisher/:publisherId/bill/:billId/resaler

GET
~~~


**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100"}' https://sandbox.iot-sw.net/bill/v1/publisher/10000/bill/3/resaler
~~~


## 开始申请一个新待出售流通票券
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/resaler/:resalerId/new-instrument

POST
~~~


**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","orderNo":"test_order_no_sale_001","customerId":10004,"billId":1,"requestValues":[{"valueId":"1","valueCode":"fly_birds"}],"tnxTimeout":120}' https://sandbox.iot-sw.net/bill/v1/resaler/10002/new-instrument
~~~


## 撤消待出售流通票券
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/resaler/:resalerId/new-instrument/:tnxId

DELETE
~~~


**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","customerId":10004}' https://sandbox.iot-sw.net/bill/v1/resaler/10002/new-instrument/3hgzim64lbi88cc0g8wg0

~~~


### 确认出售一张待出售流通票券!
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/resaler/:resalerId/new-instrument/:tnxId

PUT
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","customerId":10004}' https://sandbox.iot-sw.net/bill/v1/resaler/10002/new-instrument/3hgzim64lbi88cc0g8wg0

~~~

## 待转让流通票券
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/possessor/:possessorId/transfer

POST
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","instrumentId":"8","transfereeId":10005,"orderNo":"test_order_no_transfer_001","tnxTimeout":120}' https://sandbox.iot-sw.net/bill/v1/possessor/10004/transfer
~~~

## 流通票券待转让撤消
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/possessor/:possessorId/transfer/:tnxId

DELETE
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","instrumentId":"8","orderNo":"test_order_no_transfer_001"}' https://sandbox.iot-sw.net/bill/v1/possessor/10004/transfer/1hfic3dpxfy80w4sokgc0
~~~

## 确认流通票券转让
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/possessor/:possessorId/transfer/:tnxId

PUT
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","orderNo":"test_order_no_transfer_001","instrumentId":"8","transfereeId":10005}' https://sandbox.iot-sw.net/bill/v1/possessor/10004/transfer/1hfic3dpxfy80w4sokgc0
~~~

## 持有人申请退还一张流通票券
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/possessor/:possessorId/refund

POST
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","instrumentId":"8","resalerId":10002,"refundNo":"test_order_refund_002","tnxTimeout":"604800"}' https://sandbox.iot-sw.net/bill/v1/possessor/10005/refund
~~~

## 获取持有人的流通票券退还列表
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/possessor/:possessorId/refund

GET
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100"}' https://sandbox.iot-sw.net/bill/v1/possessor/10005/refund

~~~

## 持有人撤消流通票券退货
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/possessor/:possessorId/refund/:tnxId

DELETE
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","instrumentId":"8"}' https://sandbox.iot-sw.net/bill/v1/possessor/10005/refund/5zxgeat1xakosoo0cscww
~~~

## 分发商获取退货列表
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/resaler/:resalerId/refund

GET
~~~

**Curl demo:**

~~~js

curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","tnxStatus":["0"],"start":"","end":""}' https://sandbox.iot-sw.net/bill/v1/resaler/10002/refund

~~~

## 分发商批准退货申请
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/resaler/:resalerId/refund/:refundId

PUT
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","refundNo":"test_order_refund_0010"}' https://sandbox.iot-sw.net/bill/v1/resaler/10002/refund/5

~~~

## 分发商拒绝退货申请
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/resaler/:resalerId/refund/:refundId

DELETE
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","refundNo":"test_order_refund_0012"}' https://sandbox.iot-sw.net/bill/v1/resaler/10002/refund/6

~~~

## 申请待兑现流通票券
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/possessor/:possessorId/redeem

POST
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","instrumentId":12,"acceptorId":10003,"orderNo":"test_order_redeem_001","redeemValues":[{"valueId":1,"valueQty":1,"valueCode":["fly_birds"]}]}' https://sandbox.iot-sw.net/bill/v1/possessor/10004/redeem

~~~

## 撤消兑现流通票券
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/acceptor/:acceptorId/delivery/:tnxId

DELETE
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","orderNo":"test_order_redeem_001"}' https://sandbox.iot-sw.net/bill/v1/acceptor/10003/delivery/2ecs7wny76joo0c0osg84

~~~

## 确认兑现流通票券
**注意:根据相对应的参数进行条件修改**

**原始API:**

~~~js
https://sandbox-iot-sw.net/bill/v1/acceptor/:acceptorId/delivery/:tnxId

PUT
~~~

**Curl demo:**

~~~js
curl -X POST -H "Content-Type: application/json"  -d '{"appId":"t_10000_20000_30000","appToken":"290fbceb491e2485af389b0cc5a51100","orderNo":"test_order_redeem_002","instrumentId":12,"value":[{"valueId":1,"valueQty":1,"valueCode":["fly_birds"]}]}' https://sandbox.iot-sw.net/bill/v1/acceptor/10003/delivery/641qd41k0204wcss8kkcw
~~~



---
&copy; 2017 微数聚软件(雷山)有限公司

