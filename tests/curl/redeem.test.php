<?php
/**
 *@description : 完成一个完整的兑现流程
 *@              (1) 待兑现
 *@              (2) 撤消兑现
 *@              (3) 确认兑现
 *@author      : Stephen Mo <stephen@iot-sw.net> MDC Inc,. Ltd;
 *@date        : Apri 19, 2017
 *@version     : 1.0.0
 */

require_once dirname(__FILE__)."/CurlHelper.class.php";
require_once "./init.php";

# 域名设置指定
$billApiDomain = 'https://sandbox.iot-sw.net';

# 票券发行编号
$billId = 55;
$valueId = '42';
$instrumentId = 34;//6;//33;//,35

$orderNo      = 'test_order_redeem_001';
//$possessorId  = 10005;

echo "\n开始一个兑现流程! - (MDC Inc,.Ltd)\n\n";
echo "***(1) 申请一个待兑现请求!\n\n";

$uri = "/bill/v1/possessor/{$possessorId}/redeem";
$method = 'POST';
$parameters = [
    'appId'        => $appId,
    'appToken'     => $appToken,
    'instrumentId' => $instrumentId,
    'acceptorId'   => $acceptorId,
    'orderNo'      => $orderNo,
    'redeemValues' => [
        [
            'valueId'   => $valueId,
            'valueQty'  => 1,
            'valueCode' => ['fly_birds']
        ]
    ]
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问:{$fullApiName} 待兑现流通票券(#{$instrumentId})发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}

echo "instrumentId:".$result['content']['instrumentId']."\n";
echo "instrumentStatus:".$result['content']['instrumentStatus']."\n";
echo "tnxId:".$result['content']['tnxId']."\n";
echo "tnxStartTime:".$result['content']['tnxStartTime']."\n";
echo "tnxEndTime:".$result['content']['tnxEndTime']."\n";
echo "tnxDueTime:".$result['content']['tnxDueTime']."\n";
echo "\n\n";
echo "***(1) 申请待兑现请求成功!\n\n\n\n";

echo "(附)可调用的curl命令行模式:(申请兑现流通票券)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
echo "\n\n\n\n";

$tnxId = $result['content']['tnxId'];
 
echo "***(2) 撤消兑现流通票券!\n";
$uri = "/bill/v1/acceptor/{$acceptorId}/delivery/{$tnxId}";
$method = 'DELETE';
$parameters = [
    'appId' => $appId,
    'appToken' => $appToken,
    'orderNo' => $orderNo
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问:{$fullApiName} 撤消兑现流通票券(#{$instrumentId})发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}
echo "instrumentId:".$result['content']['instrumentId']."\n";
echo "instrumentStatus:".$result['content']['instrumentStatus']."\n";
echo "tnxId:".$result['content']['tnxId']."\n";
echo "tnxStartTime:".$result['content']['tnxStartTime']."\n";
echo "tnxRollbackTime:".$result['content']['tnxRollbackTime']."\n";
echo "\n\n";
echo "***(2) 撤消部现流通票券(#{$instrumentId})成功!\n";
echo "\n\n\n\n";

echo "(附)可调用的curl命令行模式:(撤消兑现流通票券)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
echo "\n\n\n\n";


echo "***(3) 确认兑现流通票券!\n";
$orderNo = 'test_order_redeem_002';
$uri = "/bill/v1/possessor/{$possessorId}/redeem";
$method = 'POST';
$parameters = [
    'appId'        => $appId,
    'appToken'     => $appToken,
    'instrumentId' => $instrumentId,
    'acceptorId'   => $acceptorId,
    'orderNo'      => $orderNo,
    'redeemValues' => [
        [
            'valueId'   => 1,
            'valueQty'  => 1,
            'valueCode' => ['fly_birds']
        ]
    ]
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问:{$fullApiName} 待兑现流通票券(#{$instrumentId})发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}

$tnxId = $result['content']['tnxId'];
echo "tnxId:".$result['content']['tnxId']."\n";
echo "instrumentStatus:".$result['content']['instrumentStatus']."\n";
echo "tnxStartTime:".$result['content']['tnxStartTime']."\n";
echo "tnxDueTime:".$result['content']['tnxDueTime']."\n";
echo "\n\n";


//$orderNo = 'test_order_redeem_002';
//$tnxId = '1fi9eww1i6u8gcgowkkgo';

$uri = "/bill/v1/acceptor/{$acceptorId}/delivery/{$tnxId}";
$method = 'PUT';
$parameters = [
    'appId' => $appId,
    'appToken' => $appToken,
    'orderNo' => $orderNo,
    'instrumentId' => $instrumentId,
    'value' => [
        [
            'valueId' => 1,
            'valueQty' => 1,
            'valueCode' => ['fly_birds']
        ]
    ]
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问:{$fullApiName} 确认兑现流通票券(#{$instrumentId})发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}
echo "instrumentId:".$result['content']['instrumentId']."\n";
echo "instrumentStatus:".$result['content']['instrumentStatus']."\n";
echo "tnxId:".$result['content']['tnxId']."\n";
echo "tnxStartTime:".$result['content']['tnxStartTime']."\n";
echo "tnxDueTime:".$result['content']['tnxDueTime']."\n";
echo "\n\n";
echo "***(3) 确认兑现流通票券成功!\n";
echo "\n\n\n\n";


echo "(附)可调用的curl命令行模式:(确认兑现流通票券)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
echo "\n\n\n\n";

