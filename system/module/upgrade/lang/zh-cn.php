<?php
/**
 * The upgrade module zh-cn file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id: zh-cn.php 5119 2013-07-12 08:06:42Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
$lang->upgrade->common  = '升级';

$lang->upgrade->result  = '升级结果';
$lang->upgrade->fail    = '升级失败';
$lang->upgrade->success = '升级成功';
$lang->upgrade->tohome  = '返回首页';

$lang->upgrade->index         = '检查是否可以执行升级程序';
$lang->upgrade->backup        = '备份数据';
$lang->upgrade->selectVersion = '确认升级之前的版本';
$lang->upgrade->confirm       = '确认要执行的SQL语句';
$lang->upgrade->execute       = '确认执行';

$lang->upgrade->setOkFile = <<<EOT
<h5>请按照下面的步骤操作以确认您的管理员身份。</h5>
<p><code class='f-14px'>创建 "<strong>%s</strong>" 文件。如果存在该文件，使用编辑软件打开，重新保存一遍。</code></p>
<a href="upgrade.php" class='btn btn-primary'>下一步</a>
EOT;

$lang->upgrade->backupData = <<<EOT
<pre>
<strong>使用phpMyAdmin或者mysqldump命令备份数据库。</strong>
<code class='red'>$ mysqldump -u %s</span> -p%s %s > chanzhi.sql</code>
</pre>
<a href="%s" class='btn btn-primary'>下一步</a>
EOT;

$lang->upgrade->versionNote = "务必选择正确的版本，否则会造成数据丢失。";

$lang->upgrade->fromVersions['1_1'] = '1.1.stable';
$lang->upgrade->fromVersions['1_2'] = '1.2.stable';
