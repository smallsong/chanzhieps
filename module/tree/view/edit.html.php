<?php
/**
 * The edit view of product module of XiRangEPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id: edit.html.php 824 2010-05-02 15:32:06Z wwccss $
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div id='yui-d0' style='margin-top:20px'>
  <form method='post'>
    <table class='table-1'> 
      <caption><?php echo $lang->tree->edit;?></caption>
      <?php if($tree == 'forum'):?>
      <tr>
        <th class='w-80px'><?php echo $lang->module->parent;?></th>
        <td class='f-left' style='border:0px'>
        <?php foreach($allOptionMenu as $siteID => $optionMenu)
        {
            if(!empty($optionMenu)) 
            {
                if(empty($sites[$siteID])) continue;
                echo $sites[$siteID] . '：';
                echo html::select("parents[$siteID]", $optionMenu, (isset($modules[$siteID]) ? $modules[$siteID]->parent : ''), "class='text-2'") . '<br />';
                echo html::hidden("sites[$siteID]", $siteID);
            }
        }
        ?>
        </td>
      </tr>  
      <?php else:?>
      <tr>
        <th class=''><?php echo $lang->module->parent;?></th>
        <td><?php echo html::select('parent', $optionMenu, $module->parent, "class='text-1'");?></td>
      </tr>  
      <?php endif;?>
      <tr>
        <th class=''><?php echo $lang->module->name;?></th>
        <td><?php echo html::input('name', $module->name, "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class=''><?php echo $lang->module->owners;?></th>
        <td><?php echo html::input('owners', $module->owners, "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class=''><?php echo $lang->module->desc;?></th>
        <td><?php echo html::textarea('desc', $module->desc, "class='area-1' rows=3'");?></td>
      </tr>  
      <tr>
        <th class=''><?php echo $lang->module->keyword;?></th>
        <td><?php echo html::input('keyword', $module->keyword, "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class=''><?php echo $lang->module->readonly;?></th>
        <td><input type='checkbox' name='readonly' value='1' <?php if($module->readonly) echo "checked=checked";?> /></td>
      </tr>  
      <tr><td colspan='2' class='a-center'><?php echo html::submitButton() . html::hidden('tree', $tree);?></td </tr>
    </table>
  </form>
</div>  
