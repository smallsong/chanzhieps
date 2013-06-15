<?php
/**
 * The router file of XiRangBPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     XiRangBPS
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
//error_reporting(0);

/* Load the framework. */
include '../framework/router.class.php';
include '../framework/control.class.php';
include '../framework/model.class.php';
include '../framework/helper.class.php';

/* Log the time and define the run mode. */
$startTime = getTime();
define('RUN_MODE', 'admin');

/* Instance the app. */
$app = router::createApp('pms', dirname(dirname(__FILE__)));

/* Change the request settings. */
$config->frontRequestType = $config->requestType;
$config->requestType = 'GET';
$config->default->module = 'admin'; 
$config->default->method = 'index';
if($_SERVER['SERVER_NAME'] != $config->admin->domain) die();

/* Run it. */
$dbh    = $app->connectDB();
$common = $app->loadCommon();
$app->parseRequest();
$common->checkPriv();
$app->loadModule();
