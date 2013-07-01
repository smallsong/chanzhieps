<?php
/**
 * The browse view file of block module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<form action="" method="post" id="ajaxForm">
  <table class="table table-bordered table-form">
    <caption><?php echo $lang->site->setBasic;?></caption> 
    <tr>
      <th class="w-150px"><?php echo $lang->site->name;?></th> 
      <td><?php echo html::input('name', $this->config->global->name, 'class="text-5"');?></td> 
    </tr>
    <tr>
      <th class="w-150px"><?php echo $lang->site->slogan;?></th> 
      <td><?php echo html::input('slogan', $this->config->global->slogan, 'class="text-1"');?></td> 
    </tr>
    <tr>
      <th class="w-150px"><?php echo $lang->site->desc;?></th> 
      <td><?php echo html::textarea('desc', $this->config->global->desc, 'class="area-1" rows="5"');?></td> 
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
