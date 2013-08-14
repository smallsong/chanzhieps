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
$config->nav->system = new stdclass();

$config->nav->system->home    = commonModel::createFrontLink('index', 'index');
$config->nav->system->company = commonModel::createFrontLink('company', 'index');
$config->nav->system->forum   = commonModel::createFrontLink('forum', 'index');

