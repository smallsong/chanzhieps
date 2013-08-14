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

$lang->nav->setNav   = '导航设置';
$lang->nav->add      = '添加';
$lang->nav->addChild = '添加子导航';
$lang->nav->delete   = '删除导航';

$lang->nav->inputUrl        = '请输入链接';
$lang->nav->inputTitle      = '请输入标题';
$lang->nav->cannotRemoveAll = '不能删除所有导航';

/* nav type   */
$lang->nav->types = array();
$lang->nav->types['system']  = '系统模块';
$lang->nav->types['article'] = '文章类目';
$lang->nav->types['custom']  = '自定义';

/* common navs.*/
$lang->nav->system = new stdclass();
$lang->nav->system->home     = '首页';
$lang->nav->system->company  = '关于我们';
$lang->nav->system->forum    = '论坛';
