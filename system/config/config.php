<?php
/**
 * The config file of chanzhiEPS
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     chanzhiEPS
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/* Judge class config and function getWebRoot exists or not, make sure php shells can work. */
if(!class_exists('config')){class config{}}
if(!function_exists('getWebRoot')){function getWebRoot(){}}

/* The basic settings. */
$config = new config();
$config->version     = '1.3';             // The version number, don't change.
$config->encoding    = 'UTF-8';           // The encoding.
$config->cookiePath  = '/';               // The path of cookies.
$config->webRoot     = getWebRoot();      // The web root.
$config->cookieLife  = time() + 2592000;  // The lifetime of cookies.
$config->timezone    = 'Asia/Shanghai';   // Time zone setting, more plese visit http://www.php.net/manual/en/timezones.php

/* The request settins. */
$config->requestType = 'PATH_INFO';       // PATH_INFO or GET.
$config->requestFix  = '-';               // RequestType=PATH_INFO: the divider of the params, can be - _ or /
$config->moduleVar   = 'm';               // RequestType=GET: the name of the module var.
$config->methodVar   = 'f';               // RequestType=GET: the name of the method var.
$config->viewVar     = 't';               // RequestType=GET: the name of the view var.
$config->sessionVar  = RUN_MODE . 'sid';  // The session var name.

/* Views and themes. */
$config->views       = ',html,json,xml,'; // Supported view types.
$config->themes      = 'default,blue';    // Supported themes.

/* Suported languags. */
$config->langs['zh-cn'] = '简体';
$config->langs['zh-tw'] = '繁体';
$config->langs['en']    = 'English';

/* Default params. */
$config->default = new stdclass();          
$config->default->view   = 'html';             // Default view.
$config->default->lang   = 'zh-cn';            // Default language.
$config->default->theme  = 'default';          // Default theme.
$config->default->module = 'index';            // Default module.
$config->default->method = 'index';            // Default metho.d

/* Upload settings. */
$config->file = new stdclass();          
$config->file->dangers = 'php,jsp,py,rb,asp,'; // Dangerous file types.
$config->file->maxSize = 1024 * 1024;          // Max size allowed(Byte).

/* Database settings. */
$config->db = new stdclass();          
$config->db->persistant = false;               // Persistant connection or not.
$config->db->driver     = 'mysql';             // The driver of pdo, only mysql yet.
$config->db->encoding   = 'UTF8';              // The encoding of the database.
$config->db->strictMode = false;               // Turn off the strict mode.
$config->db->prefix     = 'eps_';               // The prefix of the table name.

/* Include my.php, domain.php and front or admin.php. */
$configRoot   = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$myConfig     = $configRoot . 'my.php';
$domainConfig = $configRoot . 'domain.php';
$modeConfig   = $configRoot . RUN_MODE . '.php';

if(file_exists($myConfig))     include $myConfig;
if(file_exists($domainConfig)) include $domainConfig;
if(file_exists($modeConfig))   include $modeConfig;

/* The tables. */
define('TABLE_SITE',     $config->db->prefix . 'site');
define('TABLE_CONFIG',   $config->db->prefix . 'config');
define('TABLE_CATEGORY', $config->db->prefix . 'category');
define('TABLE_RELATION', $config->db->prefix . 'relation');
define('TABLE_PRODUCT',  $config->db->prefix . 'product');
define('TABLE_ARTICLE',  $config->db->prefix . 'article');
define('TABLE_BLOCK',    $config->db->prefix . 'block');
define('TABLE_LAYOUT',   $config->db->prefix . 'layout');
define('TABLE_COMMENT',  $config->db->prefix . 'comment');
define('TABLE_THREAD',   $config->db->prefix . 'thread');
define('TABLE_REPLY',    $config->db->prefix . 'reply');
define('TABLE_USER',     $config->db->prefix . 'user');
define('TABLE_GROUP',    $config->db->prefix . 'group');
define('TABLE_FILE',     $config->db->prefix . 'file');
define('TABLE_DOWN',     $config->db->prefix . 'down');
define('TABLE_MESSAGE',  $config->db->prefix . 'message');

/* Include extension config files. */
$extConfigFiles = glob($configRoot . 'ext/*.php');
if($extConfigFiles) foreach($extConfigFiles as $extConfigFile) include $extConfigFile;
