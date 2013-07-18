<?php
/**
 * The router file of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     xirangEPS
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
/* Turn off error reporting first. */
error_reporting(0);

/* Start output buffer. */
ob_start();

/* Define the run mode as admin. */
define('RUN_MODE', 'admin');

/* Load the framework. */
$frameworkRoot = dirname(dirname(__FILE__)) . '/framework/';
include $frameworkRoot . 'router.class.php';
include $frameworkRoot . 'control.class.php';
include $frameworkRoot . 'model.class.php';
include $frameworkRoot . 'helper.class.php';

/* Instance the app. */
$app = router::createApp('xirang', dirname(dirname(__FILE__)));
$config = $app->config;

/* Check the reqeust is getconfig or not. Check installed or not. */
if(isset($_GET['mode']) and $_GET['mode'] == 'getconfig') die($app->exportConfig());
if(!isset($config->installed) or !$config->installed) die(header('location: install.php'));

/* Change the request settings. */
$config->frontRequestType = $config->requestType;
$config->requestType = 'GET';
$config->default->module = 'admin'; 
$config->default->method = 'index';

/* Run it. */
$dbh    = $app->connectDB();
$common = $app->loadCommon();
$app->parseRequest();
$common->checkPriv();
$app->loadModule();

/* Flush the buffer. */
echo helper::removeUTF8Bom(ob_get_clean());
