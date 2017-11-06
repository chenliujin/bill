<?php
/**
 *@description : 测试一个完整的票券分发流程
 *@              (1) 申请新的待售出
 *@              (2) 售出确认
 *@              (3) 待售出撤消
 *@
 *@author      : stephen.mo <stephen@iot-sw.net> MDC Inc,.Ltd
 *@date        : Apri 18, 2017
 *@version     : 1.0.0
 */

require_once dirname(__FILE__)."/CurlHelper.class.php";
require_once "./init.php";

# 域名设置指定
$billApiDomain = 'https://sandbox.iot-sw.net';

# 票券发行编号
$billId = 55;
$valueId = '42';

echo "\n\n开始一个完整的票券分发流程! - (MDC Inc,.Ltd)\n\n";

$orderNo = 'test_order_no_sale_001';

#获取一个新的待售出流通票券
echo "***(1) 开始申请一个新待出售流通票券\n";
$uri = "/bill/v1/resaler/{$resalerId}/new-instrument";
$parameters = [
    'appId'    => $appId,
    'appToken' => $appToken,
    'orderNo'  => $orderNo,
    'customerId' => $customerId,
    'billId'     => $billId,
    'requestValues' => [
        [ 
            'valueId'   => $valueId,
            'valueCode' => 'fly_birds'
        ]
      ],
    'tnxTimeout' => 120
];

$method      = 'POST';
$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问:{$fullApiName} 发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}

$tnxId            = $result['content']['tnxId'];
$instrumentId     = $result['content']['instrumentId'];
$instrumentStatus = $result['content']['instrumentStatus'];
echo "***(1) 申请待出售流通票券成功:\n";
echo "instrumentId:  {$instrumentId}\n";
echo "instrumentStatus:  {$instrumentStatus}\n";
echo "tnxId:  {$tnxId}\n";
echo "\n\n";
echo "(附)可调用的curl命令行模式:(申请一个新的发行期号)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";

# 撤消待出售流通票券
echo "***(2) 撤消(#{$billId})的的待出售流通票券(#{$instrumentId})\n";
$uri = "/bill/v1/resaler/{$resalerId}/new-instrument/{$tnxId}";
$parameters = [
    'appId'      => $appId,
    'appToken'   => $appToken,
    'customerId' => $customerId
 ];
$method      = 'DELETE';
$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问 {$fullApiName} 撤消票券发行期(#{$billId})的待出售流通票券(#{$instrumentId})发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}

$instrumentStatus = $result['content']['instrumentStatus'];
$tnxRollbackTime  = $result['content']['tnxRollbackTime'];
echo "***(2) 撤消待出售流通票券(#{$instrumentId})成功:\n";
echo "instrumentStatus:{$instrumentStatus}\n";
echo "tnxRollbackTime:{$tnxRollbackTime}\n";
echo "\n\n";

echo "(附)可调用的curl命令行模式:(撤消待出售流通票券)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";

echo "\n\n";
echo "***(3) 确认出售一张待出售流通票券!\n";
$uri = "/bill/v1/resaler/{$resalerId}/new-instrument";
$parameters = [
    'appId'    => $appId,
    'appToken' => $appToken,
    'orderNo'  => $orderNo,
    'customerId' => $customerId,
    'billId'     => $billId,
    'requestValues' => [
        [ 
            'valueId'   => $valueId,
            'valueCode' => 'fly_birds'
        ]
      ],
    'tnxTimeout' => 120
];

$method      = 'POST';
$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问:{$fullApiName} 发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}

$tnxId            = $result['content']['tnxId'];
$instrumentId     = $result['content']['instrumentId'];
$instrumentStatus = $result['content']['instrumentStatus'];

$uri = "/bill/v1/resaler/{$resalerId}/new-instrument/{$tnxId}";
$parameters = [
    'appId'      => $appId,
    'appToken'   => $appToken,
    'customerId' => $customerId
 ];
$method      = 'PUT';
$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问 {$fullApiName} 确认票券发行期(#{$billId})的待出售流通票券(#{$instrumentId})发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}
print_r($result['content']);

echo "(附)可调用的curl命令行模式:(撤消待出售流通票券)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";










