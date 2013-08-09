<?php
/**
 * The thread module zh-cn file of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
$lang->thread->common    = '主题';

$lang->thread->id         = '编号';
$lang->thread->title      = '标题';
$lang->thread->author     = '作者';
$lang->thread->content    = '内容';
$lang->thread->file       = '附件: ';
$lang->thread->postedDate = '发表于';
$lang->thread->replies    = '回帖';
$lang->thread->views      = '阅读';
$lang->thread->lastReply  = '最后回帖';

$lang->thread->post       = '发贴';
$lang->thread->browse     = '主题列表';
$lang->thread->stick      = '置顶';
$lang->thread->editReply  = '编辑回帖';
$lang->thread->editThread = '编辑主题';

$lang->thread->sticks[0] = '不置顶';
$lang->thread->sticks[1] = '版块置顶';
$lang->thread->sticks[2] = '全局置顶';

$lang->thread->confirmDeleteThread = "您确定删除该主题吗？";
$lang->thread->confirmHideReply    = "您确定隐藏回帖吗？";
$lang->thread->confirmHideThread   = "您确定隐藏该主题吗？";
$lang->thread->confirmDeleteReply  = "您确定删除该回帖吗？";
$lang->thread->confirmDeleteFile   = "您确定删除该附件吗？";

$lang->thread->lblSpeaker     = '<strong>%s</strong><br />访问次数：%s<br />注册日期：%s<br />上次访问：%s<br />';
$lang->thread->lblEdited      = '<i>%s 最后编辑, %s</i> ';
$lang->thread->message        = '%s在论坛#%s回复了主题：%s，内容为：%s';
$lang->thread->successStick   = '成功置顶';
$lang->thread->successUnstick = '成功取消置顶';

/* Adjust the pager. */
if(!isset($lang->pager->settedInForum))
{
    $lang->pager->noRecord = '';
    $lang->pager->digest   = str_replace('记录', '回贴', $lang->pager->digest);
}
