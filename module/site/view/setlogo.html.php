<?php
/**
 * The browse view file of block module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<form method="post" id="ajaxForm" enctype="multipart/form-data">
  <table class="table table-bordered table-form">
    <caption><?php echo $lang->site->setLogo;?></caption> 
    <tr>
      <th class="w-150px">
        <?php if(isset($this->config->site->logo)) echo html::image($logo->webPath, "width='150px'");?>
      </th> 
      <td><?php echo html::file('files');?></td> 
    </tr>
    <tr>
      <td colspan="2" class="a-center">
        <?php echo html::submitButton();?>
        <span id="responser"></span>
      </td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
