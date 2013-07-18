<?php
/**
 * The user module english file of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
$lang->user->common        = 'User';
$lang->user->view          = "User info";
$lang->user->create        = "Add a user";
$lang->user->edit          = "Edit user";
$lang->user->update        = "Edit user";
$lang->user->delete        = "Delete user";
$lang->user->browse        = "Borwse";
$lang->user->deny          = "Access denied";
$lang->user->confirmDelete   = "Are you sure to delete this user?";
$lang->user->confirmActivate = "Are you sure to activate this user?";
$lang->user->relogin         = "Relogin";
$lang->user->asGuest         = "Visits as guest";
$lang->user->goback          = "Go back";
$lang->user->allUsers        = 'All users';
$lang->user->modifyPassword  = "Modify password";
$lang->user->submit          = "Submit";

$lang->user->profile     = 'Profile';
$lang->user->editProfile = 'Edit profile';
$lang->user->thread      = 'My threads';
$lang->user->reply       = 'My replies';
$lang->user->message     = 'My message';

$lang->user->inputUserName = 'Please input your username';
$lang->user->searchUser    = 'Search';

$lang->user->errorDeny     = "Sorry, you don't have the permission to access <b>%s</b>'s<b>%s</b>. Please contact the administrator.";
$lang->user->loginFailed   = "Login failed, please check you account and password.";
$lang->user->lblZenTaoID   = '';
$lang->user->lblRegistered = 'Congratulations, register successfully!';

$lang->user->forbidUser          = 'Manage user';
$lang->user->forbid              = 'Forbid';
$lang->user->forbidoneday        = 'one day';
$lang->user->forbidtwodays       = 'two days';
$lang->user->forbidthreedays     = 'three days';
$lang->user->forbidoneweek       = 'one week';
$lang->user->forbidonemonth      = 'one month';
$lang->user->forbidforever       = 'forever';
$lang->user->operate             = 'operate';

$lang->user->gendarList->m = 'Male';
$lang->user->gendarList->f = 'Female';

$lang->user->id        = 'ID';
$lang->user->account   = 'Account';
$lang->user->password  = 'Password';
$lang->user->password2 = 'Repeat it';
$lang->user->realname  = 'Name';
$lang->user->nickname  = 'Nick';
$lang->user->avatar    = 'Avatar';
$lang->user->birthyear = 'Birthyear';
$lang->user->birthday  = 'Birthday';
$lang->user->gendar    = 'Gendar';
$lang->user->email     = 'Email';
$lang->user->msn       = 'MSN';
$lang->user->qq        = 'QQ';
$lang->user->yahoo     = 'Y!';
$lang->user->gtalk     = 'GTalk';
$lang->user->wangwang  = 'Wangwang';
$lang->user->mobile    = 'Mobile';
$lang->user->phone     = 'Phone';
$lang->user->company   = 'Company';
$lang->user->address   = 'Address';
$lang->user->zipcode   = 'Zipcode';
$lang->user->join      = 'Join date';
$lang->user->visits    = 'Visits';
$lang->user->ip        = 'Last ip address';
$lang->user->last      = 'Last login time';
$lang->user->allowTime = 'Allow time';
$lang->user->status    = 'Status';
$lang->user->alert     = 'Your account has been forbidden';
$lang->user->love      = 'Love User';

$lang->user->register->welcome    = 'Welcome to register as a member.';
$lang->user->register->why        = 'After register, you can achieve mor features and services.';
$lang->user->register->lblUserInfo= 'User info';
$lang->user->register->lblAccount = 'The account must be a series of letters and/or numbers';
$lang->user->register->lblPassword= 'Please set you password, at lest six letters or numbers.';

$lang->user->notice->password = 'Numbers and letters, at least six';

$lang->user->login->common  = "Login";
$lang->user->login->welcome = 'Welcome';
$lang->user->login->why     = 'Login, and use more feature.';
$lang->user->login->openID  = 'Login with openID:';

$lang->user->control->common      = 'User dashboard';
$lang->user->control->welcome     = 'Welcome, <strong>%s</strong>';
$lang->user->control->lblPassword = "Keep empty, will not change it.";

global $config;
$lang->user->control->menus[10]  = 'Profile|user|profile';
$lang->user->control->menus[20]  = 'Edit profile|user|edit';
$lang->user->control->menus[28]  = 'My message|user|message';
if($config->features->forum)
{
    $lang->user->control->menus[30] = 'My threads|user|thread';
    $lang->user->control->menus[40] = 'My replies|user|reply';
}
$lang->user->control->menus[50]  = 'Logout|user|logout';

$lang->user->resetPassword->caption    = "Reset password";
$lang->user->resetPassword->success    = "Password change link has been sent to your mailbox";
$lang->user->resetPassword->failed     = "Please input your correct mail";

$lang->user->resetmail->subject = "Modify password";
$lang->user->resetmail->notice  = "System letter, please do not reply";

$lang->user->reset->success = 'Password changed';
