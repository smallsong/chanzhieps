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
  <div class="span3">
    <?php 
        js::set('categoryID', $currentCategoryID);
        js::set('tree', $tree);
    ?>
    <form method='post' id="treeForm" action='<?php echo $this->createLink('tree', 'updateOrder', "tree=$tree");?>'>
    <table class='table-1 table-bordered'>
      <caption><?php echo $title;?></caption>
      <tr>
        <td>
          <div id='main'><?php echo $categories;?></div>
          <div class='a-center'>
            <?php echo html::submitButton($lang->tree->updateOrder);?>
          </div>
        </td>
      </tr>
    </table>
    </form>
  </div>
  <div class="span9">
  </div>
<?php include '../../common/view/treeview.html.php';?>
<?php include '../../common/view/footer.admin.html.php';?>
