<?php
/**
 * The config items for rights for front pages..
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     xirangEPS
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
/* Init the rights. */
$config->rights = new stdclass();

/* For guest users. */
$config->rights->guest['index']['index'] = 'index';
$config->rights->guest['rss']['index'] = 'index';

$config->rights->guest['article']['index']  = 'index';
$config->rights->guest['article']['browse'] = 'browse';
$config->rights->guest['article']['view']   = 'view';

$config->rights->guest['product']['index']  = 'index';
$config->rights->guest['product']['browse'] = 'browse';
$config->rights->guest['product']['view']   = 'view';

$config->rights->guest['company']['index']   = 'index';
$config->rights->guest['company']['contact'] = 'contact';

$config->rights->guest['forum']['index'] = 'index';
$config->rights->guest['forum']['board'] = 'board';

$config->rights->guest['thread']['view'] = 'view';
$config->rights->guest['thread']['post'] = 'post';

$config->rights->guest['comment']['show'] = 'show';
$config->rights->guest['comment']['post'] = 'post';

$config->rights->guest['help']['index'] = 'index';
$config->rights->guest['help']['book']  = 'book';
$config->rights->guest['help']['read']  = 'read';

$config->rights->guest['user']['login']    = 'login';
$config->rights->guest['user']['register'] = 'register';

$config->rights->guest['rss']['index']       = 'index';
$config->rights->guest['file']['download']   = 'download';
$config->rights->guest['file']['printfiles'] = 'printfiles';

/* For logged member. */
$config->rights->member['thread']['post']       = 'post';
$config->rights->member['thread']['reply']      = 'reply';
$config->rights->member['thread']['edit']       = 'edit';
$config->rights->member['thread']['hide']       = 'hide';
$config->rights->member['thread']['stick']      = 'stick';
$config->rights->member['thread']['delete']     = 'delete';
$config->rights->member['thread']['deletefile'] = 'deletefile';

$config->rights->member['reply']['post']       = 'post';
$config->rights->member['reply']['eidt']       = 'edit';
$config->rights->member['reply']['hide']       = 'hide';
$config->rights->member['reply']['delete']     = 'delete';
$config->rights->member['reply']['deletefile'] = 'deletefile';

$config->rights->member['user']['control'] = 'control';
$config->rights->member['user']['profile'] = 'profile';
$config->rights->member['user']['edit']    = 'edit';
$config->rights->member['user']['logout']  = 'logout';
$config->rights->member['user']['thread']  = 'thread';
$config->rights->member['user']['reply']   = 'reply';
$config->rights->member['user']['message'] = 'message';

$config->rights->member['file']['ajaxupload'] = 'ajaxupload';

$config->rights->member['message']['view']        = 'view';
$config->rights->member['message']['batchdelete'] = 'batchdelete';
