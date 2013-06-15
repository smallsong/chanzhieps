<?php
$config->user = new stdclass();
$config->user->register = new stdclass();
$config->user->register->requiredFields = 'account,realname,email,password,password1,password2';
$config->user->edit = new stdclass();
$config->user->edit->requiredFields     = 'realname,email';

$config->user->openID->List['sina']   = 'sina';
$config->user->openID->List['qq']     = 'qq';
$config->user->openID->List['github'] = 'github';
$config->user->openID->List['gmail']  = 'gmail';

$config->user->openID->sina = new stdclass();
$config->user->openID->sina->akey        = "1046136484";
$config->user->openID->sina->skey        = "f47848069c56a75171b7391482845e60";
$config->user->openID->sina->callbackUrl = "http://www.xirang.biz/user-callback";
