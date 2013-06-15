<?php
$config->admin->navigate[] = array('siteID' => 18, 'module' => 'comment',   'method' => 'getLatest',    'name' => 'manageComment');
$config->admin->navigate[] = array('siteID' => 18, 'module' => 'data',      'method' => 'index',        'name' => 'businessData');
$config->admin->navigate[] = array('siteID' => 18, 'module' => 'user',      'method' => 'paypal',       'name' => 'paypalList');
$config->admin->navigate[] = array('siteID' => 18, 'module' => 'extension', 'method' => 'browseApps',   'name' => 'browseApps');
$config->admin->navigate[] = array('siteID' => 18, 'module' => 'webapp',    'method' => 'browseAdmin',  'name' => 'manageWebapp', 'params' => 'param=all&status=wait');
$config->admin->navigate[] = array('siteID' => 18, 'module' => 'user',      'method' => 'extensionLog', 'name' => 'extensionLog');
$config->admin->navigate[] = array('siteID' => 18, 'module' => 'user',      'method' => 'checkApply',   'name' => 'checkApply');
$config->admin->navigate[] = array('siteID' => 18, 'module' => 'usercase',  'method' => 'browseAdmin',  'name' => 'checkUsercase', 'params' => 'industry=all&status=0');
$config->admin->navigate[] = array('siteID' => 18, 'module' => 'gift',      'method' => 'manage',       'name' => 'manageGift');
$config->admin->navigate[] = array('siteID' => 22, 'module' => 'pms',       'method' => 'manageDomain', 'name' => 'manageDomain');
$config->admin->navigate[] = array('siteID' => 22, 'module' => 'pms',       'method' => 'manageOrder',  'name' => 'manageOrder');
