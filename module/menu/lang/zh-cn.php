<?php
/**
 * The common simplified chinese file of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      DaiTingting 
 * @package     xirangEPS
 * @version     $Id$
 * @link        http://www.zentao.net
 */

$lang->add      = '添加';
$lang->addChild = '添加子导航';
$lang->delete   = '删除导航';

$lang->inputTitle = '请输入标题';
$lang->inputUrl   = '请输入地址';

/* menu type   */
$lang->menu->types = array();
$lang->menu->types['input']   = '自定义导航';
$lang->menu->types['common']  = '通用导航';
$lang->menu->types['article'] = '文章类目导航';

/* system menus.*/
$homeLink     = helper::createLink('index');
$aboutusLink  = helper::createLink('company');
$forumLink    = helper::createLink('forum');

$lang->menu->common->home     = '首页';
$lang->menu->common->about    = '关于我们';
$lang->menu->common->forum    = '论坛';


