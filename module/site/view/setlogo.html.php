<?php
/**
 * The logo view file of site module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<form method='post' id='ajaxForm' enctype='multipart/form-data'>
  <table class='table table-form'>
    <caption><?php echo $lang->site->setLogo;?></caption> 
    <tr>
      <th class='w-150px'>
        <?php if(isset($this->config->site->logo)) echo html::image($logo->webPath, "class='w-150px'");?>
      </th> 
      <td>
        <?php echo html::file('files');?>
        <?php echo html::submitButton();?>
      </td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
