<?php
/**
 * The browse view file of site module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php $menus = json_decode($this->config->site->menu);?>
<table class="table table-hover table-bordered table-striped">
  <caption><?php echo $lang->site->menuManage;?></caption>
  <thead>
    <tr>
      <th class="w-p30"><?php echo $lang->site->menuName;?></th>
      <th class="w-p20"><?php echo $lang->site->menuType;?></th>
      <th class="w-60px"><?php echo $lang->site->menuLink;?></th>
      <th class="w-150px"><?php echo $lang->actions;?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <?php foreach($menus as $item => $menu):?>
      <?php if($menu == "") continue;?>
      <td><?php echo $menu;?></td>
      <?php endforeach;?>
     </tr>
   </tbody>
 </table>
<?php include '../../common/view/footer.admin.html.php';?>
