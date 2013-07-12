<?php
/**
 * The browse view file of block module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<form action="" method="post" id="ajaxForm">
  <table class="table table-bordered table-inline">
    <caption><?php echo $lang->site->setBasic;?></caption> 
    <tr>
      <th class="w-150px"><?php echo $lang->site->name;?></th> 
      <td><?php echo html::input('name', $this->config->site->name, 'class="text-5"');?></td> 
    </tr>
    <tr>
      <th class="w-150px"><?php echo $lang->site->slogan;?></th> 
      <td><?php echo html::input('slogan', $this->config->site->slogan, 'class="text-1"');?></td> 
    </tr>
    <tr>
      <th class="w-150px"><?php echo $lang->site->desc;?></th> 
      <td><?php echo html::textarea('desc', $this->config->site->desc, 'class="area-1" rows="5"');?></td> 
    </tr>
    <tr>
      <th class="w-150px"><?php echo $lang->site->copyrightStart;?></th> 
      <td><?php echo html::input('copyrightStart', $this->config->site->copyrightStart, 'class="text-1"');?></td> 
    </tr>
    <tr>
      <th class="w-150px"><?php echo $lang->site->icp;?></th> 
      <td><?php echo html::input('icp', $this->config->site->icp, 'class="text-1"');?></td> 
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
