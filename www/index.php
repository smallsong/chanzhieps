<?php
/**
 * The router file of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     XiRangEPS
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
/* Turn off error reporting first. */
error_reporting(0);

/* Start output buffer. */
ob_start();

/* Define the run mode as front. */
define('RUN_MODE', 'front');

/* Load the framework. using the absolute path, thus it can work anywhere even symlink to other directory. */
$frameworkRoot = dirname(dirname(__FILE__)) . '/framework/';
include $frameworkRoot . 'router.class.php';
include $frameworkRoot . 'control.class.php';
include $frameworkRoot . 'model.class.php';
include $frameworkRoot . 'helper.class.php';

/* Instance the app and run it. */
$app = router::createApp('xirang', dirname(dirname(__FILE__)));

/* Check the reqeust is getconfig or not. Check installed or not. */
if(isset($_GET['mode']) and $_GET['mode'] == 'getconfig') die($app->exportConfig());
if(!isset($config->installed) or !$config->installed) die(header('location: install.php'));

/* Connect to db, load module. */
$dbh    = $app->connectDB();
$common = $app->loadCommon();
$app->parseRequest();
$common->checkPriv();
$app->loadModule();

/* Flush the buffer. */
echo removeUTF8Bom(ob_get_clean());
