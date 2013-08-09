<?php
/**
 * The browse view file of tree category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php 
js::set('root', $root);
js::set('type', $type);
?>
<?php if(strpos($treeMenu, '<li>') !== false):?>
<div class='row-fluid'>
  <div class='span4'>
    <table class='table table-bordered'>
      <caption><?php echo $title;?></caption>
      <tr>
        <td><div id='treeMenuBox'><?php echo $treeMenu;?></div></td>
      </tr>
    </table>
  </div>
  <div class="span8" id='categoryBox'></div>
  <?php else:?>
  <div id='categoryBox'></div>
  <?php endif;?>
</div>
<?php include '../../common/view/treeview.html.php';?>
<?php include '../../common/view/footer.admin.html.php';?>
