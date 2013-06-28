<?php
/**
 * The browse view file of tree category of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<div class="row">
  <div class="u-4-1">
    <form method='post' target='hiddenwin' action='<?php echo $this->createLink('tree', 'updateOrder', "tree=$tree");?>'>
    <table class='table-1'>
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

  <div class="u-4-3">
    <form method='post' target='hiddenwin' action='<?php echo $this->createLink('tree', 'manageChild', "tree=$tree");?>'>
      <table align='center' class='table-1'>
        <caption><?php echo $lang->tree->manageChild;?></caption>
        <tr>
          <td width='10%'>
            <nobr>
            <?php
            foreach($parentCategories as $category)
            {
                echo html::a($this->createLink('tree', 'browse', "tree=$tree&categoryID=$category->id"), $category->name);
            }
            ?>
            </nobr>
          </td>
          <td> 
            <?php
            $maxOrder = 0;
            foreach($sons as $sonCategory)
            {
                if($sonCategory->order > $maxOrder) $maxOrder = $sonCategory->order;
                echo html::input("categorys[id$sonCategory->id]", $sonCategory->name, 'style="margin-bottom:5px"') . '<br />';
            }
            for($i = 0; $i < TREE::NEW_CHILD_COUNT ; $i ++) echo html::input("categorys[]", '', 'style="margin-bottom:5px"') . '<br />';
           ?>
          </td>
        </tr>
        <tr>
          <td class='a-center' colspan='2'>
            <?php 
            echo html::submitButton() . html::resetButton();
            echo html::hidden('parentCategoryID', $currentCategoryID);
            echo html::hidden('maxOrder', $maxOrder);
            ?>      
            <input type='hidden' value='<?php echo $currentCategoryID;?>' name='parentCategoryID' />
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>  
<?php include '../../common/view/footer.admin.html.php';?>
