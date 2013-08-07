<?php
/**
 * The nav config file of xirangEPS. 
 * 
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Xiying Guan
 * @package     nav
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
$config->nav->common = new stdClass();
$config->nav->common->home  = helper::createLink('index', 'index');
$config->nav->common->about = helper::createLink('company', 'index');
$config->nav->common->forum = helper::createLink('forum', 'index');

