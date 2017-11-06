<?php
/**
 *@description : 持有人转让/兑现/退货一张流通票券
 *@              (1) 待转让
 *@              (2) 撤消转让
 *@              (3) 确认转让
 *@              (4) 待退货
 *@              (5) 获取持有人退货列表
 *@              (6) 撤消退货
 *@author      : Stephen Mo <stephen@iot-sw.net> MDC Inc,. Ltd;
 *@date        : Apri 18, 2017
 *@version     : 1.0.0
 */

require_once dirname(__FILE__)."/CurlHelper.class.php";

# 域名设置指定
$billApiDomain = 'https://sandbox.iot-sw.net';
require_once "./init.php";

# 票券发行编号
$billId = 55;
$valueId = '42';
$instrumentId = '40';


echo "\n\n开始一个完整的持有者流通票券操作流程! - (MDC Inc,.Ltd)\n\n";

$orderNo = 'test_order_no_transfer_001';
#流通票券的待转让申请
echo "***(1) 流通票券待转让!\n";
$uri = "/bill/v1/possessor/{$possessorId}/transfer";
$method = 'POST';
$parameters = [
    'appId'         => $appId,
    'appToken'      => $appToken,
    'instrumentId'  => $instrumentId,
    'transfereeId'  => $transfereeId,
    'orderNo'       => $orderNo,
    'tnxTimeout'    => 120
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问:{$fullApiName} 待转让流通票券(#{$instrumentId})发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}
echo "tnxId:".$result['content']['tnxId']."\n";
echo "instrumentStatus:".$result['content']['instrumentStatus']."\n";
echo "tnxStartTime:".$result['content']['tnxStartTime']."\n";
echo "tnxDueTime:".$result['content']['tnxDueTime']."\n";
echo "instrumentAcceptStart:".$result['content']['instrumentAcceptStart']."\n";
echo "instrumentAcceptEnd:".$result['content']['instrumentAcceptEnd']."\n";
echo "\n\n";
echo "***(1) 申请流通票券(#{$instrumentId})待转让成功!\n\n\n\n";

echo "(附)可调用的curl命令行模式:(待转让流通票券)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
sleep(2);
# 待转让撤消
echo "***(2) 流通票券待转让撤消!\n";
$tnxId = $result['content']['tnxId'];
$uri = "/bill/v1/possessor/{$possessorId}/transfer/{$tnxId}";
$method = 'DELETE';
$parameters = [
    'appId' => $appId,
    'appToken' => $appToken,
    'instrumentId' => $instrumentId,
    'orderNo' => $orderNo
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问:{$fullApiName} 撤消待转让流通票券(#{$instrumentId})发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}
echo "***(2) 撤消流通票券(#{$instrumentId})待转让成功!\n\n\n\n";

echo "(附)可调用的curl命令行模式:(撤消待转让流通票券)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
sleep(2);

# 转让确定
echo "***(3) 确认流通票券转让!\n";
$uri = "/bill/v1/possessor/{$possessorId}/transfer";
$method = 'POST';
$parameters = [
    'appId'         => $appId,
    'appToken'      => $appToken,
    'instrumentId'  => $instrumentId,
    'transfereeId'  => $transfereeId,
    'orderNo'       => $orderNo,
    'tnxTimeout'    => 120
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问:{$fullApiName} 待转让流通票券(#{$instrumentId})发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}
sleep(2);

$uri = "/bill/v1/possessor/{$possessorId}/transfer/{$tnxId}";
$method = 'PUT';
$parameters = [
    'appId' => $appId,
    'appToken' => $appToken,
    'orderNo' => $orderNo,
    'instrumentId' => $instrumentId,
    'transfereeId' => $transfereeId
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问:{$fullApiName} 确认转让流通票券(#{$instrumentId})发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}
echo "***(3) 确认转让流通票券(#{$instrumentId})成功!\n\n\n\n";

echo "(附)可调用的curl命令行模式:(确认转让流通票券)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
sleep(2);

print_r($result);

# 待退还一张流通票券
echo "***(4) 持有人申请退还一张流通票券!\n";
$possessorId = 10005;

$refundNo = 'test_order_refund_002';
$uri = "/bill/v1/possessor/{$possessorId}/refund";
$method = 'POST';
$parameters = [
    'appId' => $appId,
    'appToken' => $appToken,
    'instrumentId' => $instrumentId,
    'resalerId' => $resalerId,
    'refundNo' => $refundNo,
    'tnxTimeout' => '604800', // 7天
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问:{$fullApiName} 申请退还流通票券(#{$instrumentId})发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}

$tnxId = $result['content']['tnxId'];

echo "***(4) 申请退还流通票券(#{$instrumentId})成功!\n\n\n\n";
echo "tnxId:".$tnxId."\n";
echo "instrumentId:".$instrumentId."\n";
echo "instrumentStats:".$result['content']['instrumentStatus']."\n";
echo "\n\n\n\n";

echo "(附)可调用的curl命令行模式:(申请退还流通票券)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";


# 获取持有人退还流通票券列表
echo "***(5) 获取持有人的流通票券退还列表!\n";
$uri = "/bill/v1/possessor/{$possessorId}/refund";
$method = 'GET';
$parameters = [
    'appId' => $appId,
    'appToken' => $appToken
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问:{$fullApiName} 获取持有人流通票券退货清单发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}

echo "(附)可调用的curl命令行模式:(获取持有人退还流通票券列表)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";

print_r($result['content']);
 
$tnxId = (!empty($tnxId)) ? $tnxId : '6zf8uan9ol4ww8gk4swg8';

# 撤消流通票券退货申请
echo "***(6) 持有人撤消流通票券退货!\n";
$uri = "/bill/v1/possessor/{$possessorId}/refund/{$tnxId}";
$method = 'DELETE';
$parameters = [
    'appId' => $appId,
    'appToken' => $appToken,
    'instrumentId' => $instrumentId
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问:{$fullApiName} 撤消退还流通票券(#{$instrumentId})发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}
echo "instrumentId:".$result['content']['instrumentId']."\n";
echo "instrumentStatus:".$result['content']['instrumentStatus']."\n";
echo "\n\n";

echo "***(6) 撤消退还流通票券(#{$instrumentId})成功!\n\n\n\n";

echo "(附)可调用的curl命令行模式:(撤消持有人退还流通票券)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";

echo "\n\n\n\n";


