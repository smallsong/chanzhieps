<?php
/* User used to set system root. */
//$systemRoot = '/opt/lamp/xirangsystem/';

/* Get default system root. */
if(!isset($systemRoot)) $systemRoot = dirname(dirname(__FILE__)) . '/system/';

/* If outer system path is not available use current path as system root. */
if(!is_dir($systemRoot)) $systemRoot = dirname(__FILE__) . '/system/';
if(!is_dir($systemRoot)) die('System Lost! PLS check xirang system is available. ');

/* Load the framework. */
$frameworkRoot = $systemRoot . 'framework/';

include $frameworkRoot . 'router.class.php';
include $frameworkRoot . 'control.class.php';
include $frameworkRoot . 'model.class.php';
include $frameworkRoot . 'helper.class.php';
