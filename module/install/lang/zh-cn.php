<?php
/**
 * The zh-cn language file of install module of XiRangEPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     install
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
$lang->install->common  = '安装';
$lang->install->next    = '下一步';
$lang->install->pre     = '返回';
$lang->install->reload  = '刷新';
$lang->install->error   = '错误 ';

$lang->install->start            = '开始安装';
$lang->install->keepInstalling   = '继续安装当前版本';
$lang->install->seeLatestRelease = '看看最新的版本';
$lang->install->welcome          = '欢迎使用息壤企业建站系统！';
$lang->install->desc             = <<<EOT
息壤企业建站系统是一款面向企业用户的建站系统。

息壤企业建站系统使用PHP + MySQL开发。

息壤企业建站系统由<strong class='red'><a href='http://www.xirangit.biz' target='_blank'>青岛息壤网络信息有限公司开发</a></strong>。
息壤企业建站系统的官方支持网站：<a href='http://www.xirangit.com' target='_blank'>http://www.xirang.biz</a>
您现在正在安装的版本是 <strong class='red'>%s</strong>。
EOT;

$lang->install->choice     = '您可以选择：';
$lang->install->checking   = '系统检查';
$lang->install->ok         = '<span class="text-success">检查通过(√)</span>';
$lang->install->fail       = '检查失败(×)';
$lang->install->loaded     = '已加载';
$lang->install->unloaded   = '未加载';
$lang->install->exists     = '目录存在 ';
$lang->install->notExists  = '目录不存在 ';
$lang->install->writable   = '目录可写 ';
$lang->install->notWritable= '目录不可写 ';
$lang->install->phpINI     = 'PHP配置文件';
$lang->install->checkItem  = '检查项';
$lang->install->current    = '当前配置';
$lang->install->result     = '检查结果';
$lang->install->action     = '如何修改';

$lang->install->phpVersion = 'PHP版本';
$lang->install->phpFail    = 'PHP版本必须大于5.2.0';

$lang->install->pdo          = 'PDO扩展';
$lang->install->pdoFail      = '修改PHP配置文件，加载PDO扩展。';
$lang->install->pdoMySQL     = 'PDO_MySQL扩展';
$lang->install->pdoMySQLFail = '修改PHP配置文件，加载pdo_mysql扩展。';
$lang->install->tmpRoot      = '临时文件目录';
$lang->install->dataRoot     = '上传文件目录';
$lang->install->mkdir        = '<p>需要创建目录%s。<br /> linux下面命令为：<br /> mkdir -p %s</p>';
$lang->install->chmod        = '需要修改目录 "%s" 的权限。<br />linux下面命令为：<br />chmod o=rwx -R %s';

$lang->install->settingDB    = '设置数据库';
$lang->install->webRoot      = 'CMS所在网站目录';
$lang->install->requestType  = 'URL方式';
$lang->install->requestTypes['GET']       = '普通方式';
$lang->install->requestTypes['PATH_INFO'] = '静态友好方式';
$lang->install->dbHost     = '数据库服务器';
$lang->install->dbHostNote = '如果localhost无法访问，尝试使用127.0.0.1';
$lang->install->dbPort     = '服务器端口';
$lang->install->dbUser     = '数据库用户名';
$lang->install->dbPassword = '数据库密码';
$lang->install->dbName     = 'CMS使用的库';
$lang->install->dbPrefix   = '建表使用的前缀';
$lang->install->createDB   = '自动创建数据库';
$lang->install->clearDB    = '清空现有数据';

$lang->install->errorConnectDB     = '数据库连接失败 ';
$lang->install->errorCreateDB      = '数据库创建失败';
$lang->install->errorDBExists      = '数据库已经存在，继续安装请选择清空数据';
$lang->install->errorCreateTable   = '创建表失败';
$lang->install->errorGrantPriv     = '权限初始化失败';

$lang->install->setConfig  = '生成配置文件';
$lang->install->key        = '配置项';
$lang->install->value      = '值';
$lang->install->saveConfig = '保存配置文件';
$lang->install->save2File  = '<div class="a-center"><span class="fail">尝试写入配置文件，失败！</span></div>拷贝上面文本框中的内容，将其保存到 "<strong> %s </strong>"中。您以后还可继续修改此配置文件。';
$lang->install->saved2File = '配置信息已经成功保存到" <strong>%s</strong> "中。您后面还可继续修改此文件。';
$lang->install->errorNotSaveConfig = '还没有保存配置文件';

$lang->install->getPriv  = '分配权限';
$lang->install->site     = '站点名称';
$lang->install->account  = '管理员帐号';
$lang->install->password = '管理员密码';
$lang->install->errorEmptyPassword = '密码不能为空';

$lang->install->success    = "安装成功！";
$lang->install->saveAdmin  = "请把下面两句存到config/my.php中";
$lang->install->visitFront = '访问前台';
$lang->install->visitAdmin = '访问后台';
