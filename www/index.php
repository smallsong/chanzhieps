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
error_reporting(E_ALL);
/* Start output buffer. */
ob_start();

/* Load the framework. using the absolute path, thus it can work anywhere even symlink to other directory. */
$frameworkRoot = dirname(dirname(__FILE__)) . '/framework/';
include $frameworkRoot . 'router.class.php';
include $frameworkRoot . 'control.class.php';
include $frameworkRoot . 'model.class.php';
include $frameworkRoot . 'helper.class.php';

/* Log the time and define the run mode. */
$startTime = getTime();
define('RUN_MODE', 'front');

/* Instance the app and run it. */
$app    = router::createApp('pms', dirname(dirname(__FILE__)));
$dbh    = $app->connectDB();
$common = $app->loadCommon();
$app->parseRequest();
$common->checkPriv();
$app->loadModule();

/* Flush the buffer. */
ob_end_flush();
