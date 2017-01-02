<?php

/**
 * 短信发送程序
 */

use Sofire\Qsms\Client;
use Sofire\Qsms\Request\Single;
use Sofire\Qsms\Request\Multi;

include_once __DIR__ . "/../vendor/autoload.php";

main();
exit;

function main()
{
    $content = $_POST['content'];
    $tos = $_POST['tos']; //使用逗号分隔的多个邮件地址


    $config = array();
    include_once __DIR__ . "/../config.php";

    $config = $config['qcloud_sms'];

    $appID = $config['appID'];
    $appKey = $config['appKey'];

    $client = new Client($appID, $appKey);
    if (strpos($tos, ",")) {
        $sms = new Multi($client, 0);
    } else {
        $sms = new Single($client, 0);
    }

    $sms->target($tos, '86');
    $response = $sms->normal($content);
    print_r($response);

    /*
    $tosArray = explode(",", $tos);
    foreach ($tosArray as $to) {
        $sms->target($to, '86');
        $response = $sms->normal($content);

        print_r($response);
    }
    */
}

function test()
{
    //curl -X POST $url -d "content=xxx&tos=18611112222,18611112223"
}