<?php
/**
 * The config items for rights for front pages..
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     xirangEPS
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
/* Init the rights. */
$config->rights = new stdclass();

/* For guest users. */
$config->rights->guest['index']['index'] = 'index';

$config->rights->guest['article']['index'] = 'index';
$config->rights->guest['article']['browse']= 'browse';
$config->rights->guest['article']['view']  = 'view';

$config->rights->guest['company']['index']   = 'index';
$config->rights->guest['company']['contact'] = 'contact';

$config->rights->guest['forum']['index'] = 'index';
$config->rights->guest['forum']['board'] = 'board';

$config->rights->guest['thread']['view'] = 'view';

$config->rights->guest['comment']['show'] = 'show';
$config->rights->guest['comment']['post'] = 'post';

$config->rights->guest['user']['login']    = 'login';
$config->rights->guest['user']['register'] = 'register';

$config->rights->guest['rss']['index']     = 'index';
$config->rights->guest['file']['download'] = 'download';

/* For logged member. */
$config->rights->member['thread']['post']  = 'post';
$config->rights->member['thread']['reply'] = 'reply';
$config->rights->member['thread']['edit']  = 'edit';

$config->rights->member['reply']['post'] = 'post';
$config->rights->member['reply']['eidt'] = 'edit';

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
