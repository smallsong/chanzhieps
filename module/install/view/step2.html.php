<?php
/**
 * The html template file of step2 method of install module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     XiRangEPS
 * @version     $Id$
 */
?>
<?php include './header.html.php';?>
<div class="container"> 
<form method='post' action='<?php echo $this->createLink('install', 'step3');?>' class="form-horizontal form-inline" id="form1">
  <table class='table table-bordered'>
    <caption><?php echo $lang->install->setConfig;?></caption>
    <tr>
      <th class='w-p20'><?php echo $lang->install->key;?></th>
      <th><?php echo $lang->install->value?></th>
    </tr>
    <tr>
      <th><?php echo $lang->install->dbHost;?></th>
      <td class="control-group controls"><?php echo html::input('dbHost', 'localhost', ' check-type="required" required-message="input"  ');?><?php echo $lang->install->dbHostNote;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->install->dbPort;?></th>
      <td><?php echo html::input('dbPort', '3306');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->install->dbUser;?></th>
      <td><?php echo html::input('dbUser', 'root');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->install->dbPassword;?></th>
      <td><?php echo html::input('dbPassword');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->install->dbName;?></th>
      <td><?php echo html::input('dbName', 'xirang');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->install->dbPrefix;?></th>
      <td><?php echo html::input('dbPrefix', 'xr_') . html::checkBox('clearDB', $lang->install->clearDB);?></td>
    </tr>
    <tr>
      <td colspan='2' class="a-center"><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
</div>
<script>
</script>
<?php include './footer.html.php';?>
