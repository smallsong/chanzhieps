<?php
/**
 * The loader file of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     xirangEPS
 * @version     $Id$
 * @link        http://www.xirang.biz
 */

/* User used to set system root. */
#$systemRoot = '/opt/lamp/xirangsystem/';

/* Use  ../system as default system root. */
if(!isset($systemRoot)) $systemRoot = dirname(dirname(__FILE__)) . '/system/';

/* If outer system path is not available use ./system as system root. */
if(!is_dir($systemRoot)) $systemRoot = dirname(__FILE__) . '/system/';

if(!is_dir($systemRoot)) die('System Lost! PLS check xirang system is available. ');

/* Load the framework. */
$frameworkRoot = $systemRoot . 'framework/';

include $frameworkRoot . 'router.class.php';
include $frameworkRoot . 'control.class.php';
include $frameworkRoot . 'model.class.php';
include $frameworkRoot . 'helper.class.php';
