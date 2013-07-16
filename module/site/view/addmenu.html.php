<?php
/**
 * The browse view file of block module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     company
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<form method="post" id="ajaxForm">
  <table class="table table-bordered table-form">
    <caption><?php echo $lang->site->setMenu;?></caption> 
    <tr>
      <th class="w-150px"><?php echo $lang->site->menuType?></th> 
      <td><?php echo html::input('menuType', isset($site->menuType) ? $site->menuType : '', 'class="text-1"');?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->site->menuName;?></th> 
      <td><?php echo html::input('menuName',  isset($site->menuName) ? $site->menuName : '', 'class="text-1"');?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->site->menuLink;?></th> 
      <td><?php echo html::input('menuLink', isset($site->menuLink) ? $site->menuLink : '', 'class="text-1"');?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->site->menuOrder;?></th> 
      <td><?php echo html::input('menuOrder', isset($site->menuOrder) ? $site->menuOrder : '', 'class="text-1"');?></td> 
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
