<?php
/**
 *@description : 完成分发商对退货申请的批准与拒绝
 *@              (1) 获取分发商名下的退货列表
 *@              (2) 批准退货请求
 *@              (3) 拒绝退货请求
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

echo "\n开始一个退货流程! - (MDC Inc,.Ltd)\n\n";

$testInstrumentId = [36, 38];

foreach ($testInstrumentId as $_instrumentId) 
{
    $refundNo = 'test_order_refund_00'.$_instrumentId;
    $uri = "/bill/v1/possessor/{$possessorId}/refund";
    $method = 'POST';
    $parameters = [
        'appId' => $appId,
        'appToken' => $appToken,
        'instrumentId' => $_instrumentId,
        'resalerId' => $resalerId,
        'refundNo' => $refundNo,
        'tnxTimeout' => '604800', // 7天
    ];

    $fullApiName = "{$billApiDomain}{$uri}";
    $curlObj     = CurlHelper::getInstance($method);
    $result      = $curlObj->request($fullApiName,$parameters,$method);
    
    if (!isset($result['status']) || $result['status'] != 'succ') {
        echo "访问:{$fullApiName} 申请退还流通票券(#{$_instrumentId})发生错误!\n";
        print_r($result['content']);
        echo "\n\n";
        exit;
    }
    
    $tnxId = $result['content']['tnxId'];
    echo "***(?) 申请退还流通票券(#{$_instrumentId})成功! 状态为:".$result['content']['instrumentStatus']."\n\n";
}


# 获取退货列表(分发商)
echo "***(1) 获取分发商({$resalerId})名下退货列表:\n";
$uri = "/bill/v1/resaler/{$resalerId}/refund";
$method = 'GET';
$parameters = [
    'appId'         => $appId,
    'appToken'      => $appToken,
    'tnxStatus'     => ['0'],
    'start'         => '',
    'end'           => ''
];

$fullApiName = "{$billApiDomain}{$uri}";
$curlObj     = CurlHelper::getInstance($method);
$result      = $curlObj->request($fullApiName,$parameters,$method);

if (!isset($result['status']) || $result['status'] != 'succ') {
    echo "访问:{$fullApiName} 获取分发商流通票券退货列表发生错误!\n";
    print_r($result['content']);
    echo "\n\n";
    exit;
}

$refundTotal = $result['content']['count'];
echo "***(1) 取得分发商({$resalerId})名下处理状态为(0)的待退货总数 :".$refundTotal."\n\n\n\n";
echo "(附)可调用的curl命令行模式:(分发商获取退货列表)\n";
echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
echo "\n\n";

if ($refundTotal > 0)
{
    if ($refundTotal < 2)
    {
        echo "***(2) 批准和拒绝测试最少需要2条以上的退货申请才能完成,请先申请(@{$resalerId})名下的退货申请!\n\n";
        exit;
    }

    $i = 0;

    foreach ($result['content']['refunds'] as $refunds) 
    {
        $consentRefundId = 0;
        $refuseRefundId  = 0;

        if ($i >= 2) 
        {
            break;
        }

        if ($i%2 == 0)
        {
            $consentRefundId = $refunds['instrumentSnap']['refundId'];
        }
        else
        {
            $refuseRefundId = $refunds['instrumentSnap']['refundId'];
        }

        $refundNo = (isset($refunds['instrumentSnap']['refundNo'])) ? $refunds['instrumentSnap']['refundNo'] : '';

        $_instrumentId = (isset($refunds['instrumentSnap']['instrumentId'])) ? $refunds['instrumentSnap']['instrumentId'] : null;

        if (empty($refundNo) && !empty($_instrumentId)) {
            $refundNo = 'test_order_refund_00'.$_instrumentId;
        }

        if (!empty($consentRefundId))
        {
            # 批准退货
            echo "***(2) 分发商({$resalerId})批准订单号(#{$consentRefundId})的退货申请!\n";
            $uri = "/bill/v1/resaler/{$resalerId}/refund/{$consentRefundId}";
            $method = 'PUT';
            $parameters = [
                'appId' => $appId,
                'appToken' => $appToken,
                'refundNo' => $refundNo
              ];

            $fullApiName = "{$billApiDomain}{$uri}";
            $curlObj     = CurlHelper::getInstance($method);
            $result      = $curlObj->request($fullApiName,$parameters,$method);
            
            if (!isset($result['status']) || $result['status'] != 'succ') {
                echo "访问:{$fullApiName} 批准(#{$consentRefundId})退货请求发生错误!\n";
                print_r($result['content']);
                echo "\n\n";
                exit;
            }
            
            echo "***(2) 批准(#{$consentRefundId})成功!\n";
            echo "instrumentId:".$result['content']['instrumentId']."\n";
            echo "instrumentStatus:".$result['content']['instrumentStatus']."\n";
            echo "tnxId:".$result['content']['tnxId']."\n";
            echo "tnxStatus:".$result['content']['tnxStatus']."\n";
            echo "tnxStartTime:".$result['content']['tnxStartTime']."\n";
            echo "tnxEndTime:".$result['content']['tnxEndTime']."\n";
            echo "tnxDueTime:".$result['content']['tnxDueTime']."\n"; 
            echo "\n\n\n\n";

            echo "(附)可调用的curl命令行模式:(分发商获取退货列表)\n";
            echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
            echo "\n\n";
        }

        if (!empty($refuseRefundId))
        {
            # 拒绝退货
            echo "***(3) 分发商({$resalerId})拒绝订单号(#{$refuseRefundId})的退货申请!\n";
            $uri = "/bill/v1/resaler/{$resalerId}/refund/{$refuseRefundId}";
            $method = 'DELETE';
            $parameters = [
                'appId' => $appId,
                'appToken' => $appToken,
                'refundNo' => $refundNo
            ]; 
            
            $fullApiName = "{$billApiDomain}{$uri}";
            $curlObj     = CurlHelper::getInstance($method);
            $result      = $curlObj->request($fullApiName,$parameters,$method);
            
            if (!isset($result['status']) || $result['status'] != 'succ') {
                echo "访问:{$fullApiName} 拒绝(#{$refuseRefundId})退货请求发生错误!\n";
                print_r($result['content']);
                echo "\n\n";
                exit;
            }

            echo "***(3) 拒绝(#{$refuseRefundId})成功!\n";
            echo "instrumentId:".$result['content']['instrumentId']."\n";
            echo "instrumentStatus:".$result['content']['instrumentStatus']."\n";
            echo "tnxId:".$result['content']['tnxId']."\n";
            echo "tnxStatus:".$result['content']['tnxStatus']."\n";
            echo "tnxStartTime:".$result['content']['tnxStartTime']."\n";
            echo "tnxEndTime:".$result['content']['tnxEndTime']."\n";
            echo "tnxDueTime:".$result['content']['tnxDueTime']."\n"; 
            echo "\n\n\n\n";
            echo "(附)可调用的curl命令行模式:(分发商获取退货列表)\n";
            echo "curl -X POST -H \"Content-Type: application/json\"  -d '".json_encode($parameters)."' {$fullApiName}"."\n\n";
            echo "\n\n\n";
        }

        $i++;
    }
}



