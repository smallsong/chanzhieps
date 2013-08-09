<?php
/**
 * The forum module zh-cn file of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     forum
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
$lang->forum->board       = '版块';
$lang->forum->owners      = '版主';
$lang->forum->threadList  = '主题列表';
$lang->forum->threadCount = '主题数';
$lang->forum->postCount   = '帖子数';
$lang->forum->lastPost    = '最后发表';
$lang->forum->readonly    = '只读版块。';
$lang->forum->post        = '发贴';
$lang->forum->lblOwner    = " [版主：%s]";

/* Adjust the pager. */
$lang->pager->noRecord      = '';
$lang->pager->digest        = str_replace('记录', '主题', $lang->pager->digest);
$lang->pager->settedInForum = true;    // Set this switch thus in thread module can avoid overiding them.
