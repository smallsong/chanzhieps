<?php
/**
 * The config file of XiRangEPS
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     XiRangEPS
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
/* The basic settings. */
$config->version     = '1.0';             // The version number, don't change.
$config->encoding    = 'UTF-8';           // The encoding.
$config->cookiePath  = '/';               // The path of cookies.
$config->webRoot     = '';                // The web root.
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
$config->db->prefix     = 'xr_';               // The prefix of the table name.

/* Domain postfix lists, used by setSiteCode() function in router.class.php. */
$config->domainPostfix  = "|asia|biz|cc|cd|cm|cn|co|co.jp|co.kr|co.uk|";
$config->domainPostfix .= "|com|com.cn|com.hk|com.tw|com.vc|edu.cn|es|";
$config->domainPostfix .= "|eu|fm|gov.cn|gs|hk|im|in|info|jp|kr|la|me|";
$config->domainPostfix .= "|mobi|my|name|net|net.cn|org|org.cn|pk|pro|";
$config->domainPostfix .= "|sg|so|tel|tk|to|travel|tv|tw|uk|us|ws|";
$config->domainPostfix .= "|ac.cn|bj.cn|sh.cn|tj.cn|cq.cn|he.cn|sn.cn|";
$config->domainPostfix .= "|sx.cn|nm.cn|ln.cn|jl.cn|hl.cn|js.cn|zj.cn|";
$config->domainPostfix .= "|ah.cn|fj.cn|jx.cn|sd.cn|ha.cn|hb.cn|hn.cn|";
$config->domainPostfix .= "|gd.cn|gx.cn|hi.cn|sc.cn|gz.cn|yn.cn|gs.cn|";
$config->domainPostfix .= "|qh.cn|nx.cn|xj.cn|tw.cn|hk.cn|mo.cn|xz.cn|";

/* Include the custom config file. */
$configRoot = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$myConfig   = $configRoot . 'my.php';
if(file_exists($myConfig)) include $myConfig;

/* The tables. */
define('TABLE_SITE',    $config->db->prefix . 'site');
define('TABLE_MODULE',  $config->db->prefix . 'module');
define('TABLE_ARTICLE', $config->db->prefix . 'article');
define('TABLE_BLOCK',   $config->db->prefix . 'block');
define('TABLE_LAYOUT',  $config->db->prefix . 'layout');
define('TABLE_COMMENT', $config->db->prefix . 'comment');
define('TABLE_THREAD',  $config->db->prefix . 'thread');
define('TABLE_REPLY',   $config->db->prefix . 'reply');
define('TABLE_USER',    $config->db->prefix . 'user');
define('TABLE_GROUP',   $config->db->prefix . 'group');
define('TABLE_FILE',    $config->db->prefix . 'file');
define('TABLE_MESSAGE', $config->db->prefix . 'message');
