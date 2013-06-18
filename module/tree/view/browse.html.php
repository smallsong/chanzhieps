<?php
/**
 * The browse view file of tree module of XiRangEPS.
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
<?php include '../../common/view/colorbox.html.php';?>
<div class="row">
  <div class="u-4-1">
    <form method='post' target='hiddenwin' action='<?php echo $this->createLink('tree', 'updateOrder', "tree=$tree");?>'>
    <table class='table-1'>
      <caption><?php echo $header->title;?></caption>
      <tr>
        <td>
          <div id='main'><?php echo $modules;?></div>
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
            echo html::a($this->createLink('tree', 'browse', "tree=$tree"), $this->session->site->name);
            echo $lang->arrow;
            foreach($parentModules as $module)
            {
                echo html::a($this->createLink('tree', 'browse', "tree=$tree&moduleID=$module->id"), $module->name);
                echo $lang->arrow;
            }
            ?>
            </nobr>
          </td>
          <td> 
            <?php
            $maxOrder = 0;
            foreach($sons as $sonModule)
            {
                if($sonModule->order > $maxOrder) $maxOrder = $sonModule->order;
                echo html::input("modules[id$sonModule->id]", $sonModule->name, 'style="margin-bottom:5px"') . '<br />';
            }
            for($i = 0; $i < TREE::NEW_CHILD_COUNT ; $i ++) echo html::input("modules[]", '', 'style="margin-bottom:5px"') . '<br />';
           ?>
          </td>
        </tr>
        <tr>
          <td class='a-center' colspan='2'>
            <?php 
            echo html::submitButton() . html::resetButton();
            echo html::hidden('parentModuleID', $currentModuleID);
            echo html::hidden('maxOrder', $maxOrder);
            ?>      
            <input type='hidden' value='<?php echo $currentModuleID;?>' name='parentModuleID' />
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>  
<?php include '../../common/view/footer.admin.html.php';?>
