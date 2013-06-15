#!/usr/bin/php
<?php
<<<TC
title: testing the logic for site code.
expect:|
    xirang
    xirang
    xirang
    xirang
    xirang
    xirang
    192.168.1.1
TC;

/* Include router and helper.class.php. */
include '../../router.class.php';
include '../../helper.class.php';

/* Create the router object. */
$router = router::createApp('test', '../../../');

/* Set the severname as www.xirang.com. */
$router->server->set('SERVER_NAME', 'www.xirang.com');
$router->setSiteCode();
echo $router->siteCode . "\n";

/* Set the severname as xirang.com. */
$router->server->set('SERVER_NAME', 'xirang.com');
$router->setSiteCode();
echo $router->siteCode . "\n";

/* Set the severname as xirang.com.cn */
$router->server->set('SERVER_NAME', 'xirang.com.cn');
$router->setSiteCode();
echo $router->siteCode . "\n";

/* Set the severname as www.xirang.com.cn */
$router->server->set('SERVER_NAME', 'www.xirang.com.cn');
$router->setSiteCode();
echo $router->siteCode . "\n";

/* Set the severname as www.xirang.cn */
$router->server->set('SERVER_NAME', 'www.xirang.cn');
$router->setSiteCode();
echo $router->siteCode . "\n";

/* Set the severname as xirang */
$router->server->set('SERVER_NAME', 'xirang');
$router->setSiteCode();
echo $router->siteCode . "\n";

/* Set the severname as 192.168.1.1 */
$router->server->set('SERVER_NAME', '192.168.1.1');
$router->setSiteCode();
echo $router->siteCode . "\n";
