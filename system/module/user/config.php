<?php
$config->user->register = new stdclass();
$config->user->register->requiredFields = 'account,realname,email,password1';

$config->user->edit = new stdclass();
$config->user->edit->requiredFields = 'realname,email';

$config->user->default = new stdclass();
$config->user->default->module = RUN_MODE == 'front' ? 'user'    : 'admin';
$config->user->default->method = RUN_MODE == 'front' ? 'control' : 'index';
