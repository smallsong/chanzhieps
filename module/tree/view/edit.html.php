<?php
/**
 * The edit view of product category of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id: edit.html.php 824 2010-05-02 15:32:06Z wwccss $
 * @link        http://www.xirang.biz
 */
?>
<form method='post' action="<?php echo inlink('edit', array('categoryID' => $_GET['category'], 'tree'=>$_GET['tree']));?>" id='editForm'>
    <table class='table table-bordered table-form'> 
      <caption><?php echo $lang->tree->edit;?></caption>
      <?php if($tree == 'forum'):?>
      <tr>
        <th class='w-80px'><?php echo $lang->category->parent;?></th>
        <td class='f-left' style='border:0px'>
        <?php foreach($allOptionMenu as $siteID => $optionMenu)
        {
            if(!empty($optionMenu)) 
            {
                if(empty($sites[$siteID])) continue;
                echo $sites[$siteID] . '：';
                echo html::select("parents[$siteID]", $optionMenu, (isset($categorys[$siteID]) ? $categorys[$siteID]->parent : ''), "class='text-2'") . '<br />';
                echo html::hidden("sites[$siteID]", $siteID);
            }
        }
        ?>
        </td>
      </tr>  
      <?php else:?>
      <tr>
        <th class='w-100px'><?php echo $lang->category->parent;?></th>
        <td><?php echo html::select('parent', $optionMenu, $category->parent, "class='text-1'");?></td>
      </tr>  
      <?php endif;?>
      <tr>
        <th class=''><?php echo $lang->category->name;?></th>
        <td><?php echo html::input('name', $category->name, "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class=''><?php echo $lang->category->owners;?></th>
        <td><?php echo html::input('owners', $category->owners, "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class=''><?php echo $lang->category->desc;?></th>
        <td><?php echo html::textarea('desc', $category->desc, "class='area-1' rows=3'");?></td>
      </tr>  
      <tr>
        <th class=''><?php echo $lang->category->keyword;?></th>
        <td><?php echo html::input('keyword', $category->keyword, "class='text-1'");?></td>
      </tr>  
<?php if(0):?>
      <tr>
        <th class=''><?php echo $lang->category->readonly;?></th>
        <td><input type='checkbox' name='readonly' value='1' <?php if($category->readonly) echo "checked=checked";?> /></td>
      </tr>  
<?php endif;?>
      <tr><td colspan='2' class='a-center'><?php echo html::submitButton() . html::hidden('tree', $tree);?></td </tr>
    </table>
  </form>
  <?php if(isset($pageJS)) js::execute($pageJS);?>
