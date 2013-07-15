<?php
/**
 * The config items for front.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     XiRangEPS
 * @version     $Id$
 * @link        http://www.xirang.biz
 */

$config->front = new stdclass();
$config->front->groups = new stdclass();

/* For guest users. */
$config->front->groups->guest['index'][]   = 'index';

$config->front->groups->guest['article'][] = 'index';
$config->front->groups->guest['article'][] = 'browse';
$config->front->groups->guest['article'][] = 'view';

$config->front->groups->guest['company'][]   = 'index';
$config->front->groups->guest['company'][]   = 'contact';

$config->front->groups->guest['forum'][]   = 'index';
$config->front->groups->guest['forum'][]   = 'board';

$config->front->groups->guest['thread'][]  = 'view';

$config->front->groups->guest['comment'][] = 'show';
$config->front->groups->guest['comment'][] = 'post';
$config->front->groups->guest['comment'][] = 'isgarbage';
$config->front->groups->guest['comment'][] = 'checkcode';
$config->front->groups->guest['comment'][] = 'ajaxgetcomment';

$config->front->groups->guest['rss'][]     = 'index';
$config->front->groups->guest['file'][]    = 'download';

$config->front->groups->guest['user'][]    = 'login';
$config->front->groups->guest['user'][]    = 'register';

/* For logged users. */
$config->front->groups->user['thread'][]   = 'post';
$config->front->groups->user['thread'][]   = 'reply';
$config->front->groups->user['thread'][]   = 'editthread';
$config->front->groups->user['thread'][]   = 'editreply';
$config->front->groups->user['thread'][]   = 'post';
$config->front->groups->user['thread'][]   = 'stick';
$config->front->groups->user['thread'][]   = 'deletethread';
$config->front->groups->user['thread'][]   = 'deletereply';

$config->front->groups->user['user'][]     = 'control';
$config->front->groups->user['user'][]     = 'profile';
$config->front->groups->user['user'][]     = 'edit';
$config->front->groups->user['user'][]     = 'logout';
$config->front->groups->user['user'][]     = 'thread';
$config->front->groups->user['user'][]     = 'reply';
$config->front->groups->user['user'][]     = 'message';
$config->front->groups->user['user'][]     = 'resetpassword';

$config->front->groups->user['file'][]     = 'ajaxupload';

$config->front->groups->user['message'][]  = 'view';
$config->front->groups->user['message'][]  = 'batchdelete';

/* For admin users. */
$config->front->groups->admin['thread'][]  = 'stick';
$config->front->groups->admin['thread'][]  = 'hidepost';
$config->front->groups->admin['thread'][]  = 'deletethread';
$config->front->groups->admin['thread'][]  = 'deletereply';
$config->front->groups->admin['thread'][]  = 'deletefile';
