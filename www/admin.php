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
error_reporting(E_ALL);

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

/* Run it. */
$dbh    = $app->connectDB();
$common = $app->loadCommon();
$app->parseRequest();
$common->checkPriv();
$app->loadModule();

/* Flush the buffer. */
echo removeUTF8Bom(ob_get_clean());
