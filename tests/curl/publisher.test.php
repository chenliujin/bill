<?php
/**
 *@description : 测试一个完整的票券发行流程,包括以下主要步骤
 *@              (1) 申请新的发行编号
 *@              (2) 更新发行期的基础信息设置
 *@              (3) 添加发行期的可兑换项目
 *@              (4) 设置最终承兑商
 *@              (5) 添加普通承兑商
 *@              (6) 添加普通分发商
 *@
 *@author      : stephen.mo <stephen@iot-sw.net> MDC Inc,.Ltd
 *@date        : Apri 18, 2017
 *@version     : 1.0.0
 */

require_once dirname(__FILE__)."/CurlHelper.class.php";
require_once "./init.php";

# 域名设置指定
$billApiDomain = 'https://sandbox.iot-sw.net';

echo "\n\n开始一个完整的票券发行流程! - (MDC Inc,.Ltd)\n\n";

#获取一个新的票券发行编号,调用API(bill/v1/publisher/{$publisherId}/bill)
echo "***(1) 开始申请一个新的发行\n";
$uri = "/bill/v1/publisher/{$publisherId}/bill";
$parameters = [
        'appId' => $appId,
        'appToken' => $appToken
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

$billId     = $result['content']['billId'];
$billStatus = $result['content']['billStatus'];
$billNo     = $result['content']['billNo'];

echo "(附)可调用的curl命令行模式:(申请一个新的发行期号)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
/**
$billId = 15;
$billNo = 'NO.20170417084200.00000015';
$billStatus = 1;
 */
echo "billId:{$billId}\n";
echo "billNo:{$billNo}\n";
echo "billStatus:{$billStatus}\n";

# 更新票券发行基础数据
echo "***(2) 更新票券发行期(#{$billId})的基础数据:\n";
$uri = "/bill/v1/publisher/{$publisherId}/bill/{$billId}";
$parameters = [
    'appId'                        => $appId,
    'appToken'                     => $appToken,
    'billFacadeLabelTemplate'      => 'test label Templace',
    'billFacadeTitle'              => 'Bill demo 2',
    'billFacadeDetail'             => 'just a demo',
    'billFacadeLogo'               => 'http://images.iot-sw.com/images/logo/bill/test.png',
    'billFacadeMoreLink'           => 'http://more.iot-sw.com/links/more/test.html',
    'billDistributionAmount'       => '10000',
    'billDistributionStart'        => '2017-11-05 22:00:00',
    'billDistributionEnd'          => '2018-08-17 23:59:59',
    'billAcceptanceTimeType'       => '1',
    'billAcceptanceFixRangeStart'  => '2017-11-05 22:00:00',
    'billAcceptanceFixRangeEnd'    => '2018-04-18 23:59:59',
 ];
$method      = 'PUT';
$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问 {$fullApiName} 更新指定票券发行期(#{$billId})的基础数据发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}

echo "(附)可调用的curl命令行模式:(更新发行期的基础数据)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";

$billStatus = $result['content']['billStatus'];
//$billStatus  = 2;
echo "***当前票券发行期(#{$billId})的状态为: ( {$billStatus} )\n\n";

# 添加可兑换项目
echo "***(3) 添加票券发行期(#{$billId})的可兑换项目数据:\n";
$uri    = "/bill/v1/publisher/{$publisherId}/bill/{$billId}/value";
$method = 'POST';

$parameters = [
    'appId'         => $appId,
    'appToken'      => $appToken,
    'valueSort'     => '1',
    'valueType'     => 'Games',
    'valueSubType'  => 'temp',
    'valueUnit'     => '次',
    'valueQty'      => '1',
    'valueCodeList' => ["fly_birds"] 
  ];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问 {$fullApiName} 添加指定票券发行期(#{$billId})的可兑换项目时发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}

$valueId = $result['content']['valueId'];

echo "(附)可调用的curl命令行模式:(添加票券的可兑换项目数据)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";

#$billId = 15;
#$publisherId = 10000;
#$billStatus = 2;
#$valueId = 1;
#
echo "***新增票券发行期(#{$billId})的可兑换项目成功, (可兑换项目编号:{$valueId})\n\n";

# 添加最终承兑商
echo "***(4) 设置票券发行期(#{$billId})的最终承兑商数据:\n";
$finalAcceptorId = '10001';

$uri    = "/bill/v1/publisher/{$publisherId}/bill/{$billId}/finalAcceptor";
$method = 'PUT';
$parameters = [
    'appId'                => $appId,
    'appToken'             => $appToken,
    'finalAcceptorId'      => $finalAcceptorId,
    'finalAcceptorType'    => '2',
    'finalAcceptorName'    => '好又多综合超市',
    'finalAcceptorLogo'    => 'http://images.iot-sw.net/images/logo/test.png'
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问 {$fullApiName} 设置指定票券发行期(#{$billId})的最终承兑商失败!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}
echo "(附)可调用的curl命令行模式:(设置票券的最终承兑商)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
echo "***设置票券发行期(#{$billId})的最终承兑商成功!\n\n";

# 添加普通承兑商
echo "***(5) 添加票券发行期(#{$billId})的普通承兑商数据:\n";
$acceptorId = '10002';

$uri    = "/bill/v1/publisher/{$publisherId}/bill/{$billId}/acceptor";
$method = 'POST';
$parameters = [
    'appId'        => $appId,
    'appToken'     => $appToken,
    'acceptorId'   => $acceptorId,
    'acceptorType' => '1',
    'acceptorName' => '好又多西丽店',
    'acceptorLogo' => 'http://images.iot-sw.net/images/logo/test.png',
    'acceptQty'    => '500',
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问 {$fullApiName} 添加指定票券发行期(#{$billId})的普通承兑商失败!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}

echo "(附)可调用的curl命令行模式:(添加票券的普通承兑商)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";

$billAcceptorId = $result['content']['billAcceptorId'];
echo "***添加票券发行期(#{$billId})的普通承兑商(#{$billAcceptorId})-@{$acceptorId})成功!\n\n";

# 添加普通分发商
echo "***(6) 添加票券发行期(#{$billId})的普通分发商数据:\n";
$uri       = "/bill/v1/publisher/{$publisherId}/bill/{$billId}/resaler";
$method    = 'POST';
$parameters = [
    'appId'         => $appId,
    'appToken'      => $appToken,
    'resalerId'     => $resalerId,
    'resalerType'   => '1',
    'resalerName'   => '西丽肉菜综合市场',
    'resalerLogo'   => 'http://images.iot-sw.net/images/logo/test.png',
    'resalerQty'    => '500',
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问 {$fullApiName} 添加指定票券发行期(#{$billId})的普通分发商失败!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}

echo "(附)可调用的curl命令行模式:(添加票券的普通分发商)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";

$billResalerId = $result['content']['billResalerId'];
echo "***添加票券发行期(#{$billId})的普通分发商(#{$billResalerId}-@{$resalerId})成功!\n\n\n";

# 获取完整的票券发行期数据
echo "***(7) 查询票券发行期数据!\n\n";
$uri    = "/bill/v1/publisher/{$publisherId}/bill";
$method = 'GET';
$parameters = [
    'appId'      => $appId,
    'appToken'   => $appToken,
    'keyword'    => 'Bill demo',
    'billStatus' => ['2'],
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问 {$fullApiName} 获取票券列表数据失败!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}
echo "(附)可调用的curl命令行模式:(获取票券列表数据)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
print_r($result['content']);

# 获取票券的可兑换项目列表
echo "***(8) 获取票券的可兑换项目列表数据!\n\n";
$uri = "/bill/v1/publisher/{$publisherId}/bill/{$billId}/value";
$method = 'GET';
$parameters = [
        'appId' => $appId,
        'appToken' => $appToken
 ];
$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问 {$fullApiName} 获取票券可兑换项目列表数据失败!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}
echo "(附)可调用的curl命令行模式:(获取票券可兑换项目列表数据)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
print_r($result['content']);

# 获取票券的普通承兑商列表
echo "***(9) 获取票券的普通承兑商列表数据!\n\n";
$uri = "/bill/v1/publisher/{$publisherId}/bill/{$billId}/acceptor";
$method = 'GET';
$parameters = [
        'appId' => $appId,
        'appToken' => $appToken
 ];
$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问 {$fullApiName} 获取票券普通承兑商列表数据失败!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}
echo "(附)可调用的curl命令行模式:(获取票券普通承兑商列表数据)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
print_r($result['content']);


# 获取票券的普通分发商列表
echo "***(10) 获取票券的普通分发商列表数据!\n\n";
$uri = "/bill/v1/publisher/{$publisherId}/bill/{$billId}/resaler";
$method = 'GET';
$parameters = [
        'appId' => $appId,
        'appToken' => $appToken
 ];
$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问 {$fullApiName} 获取票券普通分发商列表数据失败!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}
echo "(附)可调用的curl命令行模式:(获取票券普通分发商列表数据)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
print_r($result['content']);







