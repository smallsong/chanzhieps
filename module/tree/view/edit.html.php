<?php
/**
 * The edit view of tree category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id: edit.html.php 824 2010-05-02 15:32:06Z wwccss $
 * @link        http://www.xirang.biz
 */
?>
<form method='post' id='editForm' action="<?php echo inlink('edit', 'categoryID='.$category->id);?>" class='form-inline'>
  <table class='table table-form'> 
    <caption><?php echo $lang->tree->edit;?></caption>
    <tr>
      <th class='w-100px'><?php echo $lang->category->parent;?></th>
      <td><?php echo html::select('parent', $optionMenu, $category->parent, "class='select-3'");?></td>
    </tr>  
    <tr>
      <th><?php echo $lang->category->name;?></th>
      <td><?php echo html::input('name', $category->name, "class='text-3'");?></td>
    </tr>  
    <tr>
      <th><?php echo $lang->category->keyword;?></th>
      <td><?php echo html::input('keyword', $category->keyword, "class='text-1'");?></td>
    </tr>  
    <tr>
      <th><?php echo $lang->category->desc;?></th>
      <td><?php echo html::textarea('desc', $category->desc, "class='area-1' rows=3'");?></td>
    </tr>  
    <?php if($category->type == 'forum'):?>
    <tr>
      <th><?php echo $lang->category->moderators;?></th>
      <td><?php echo html::input('moderators', $category->moderators, "class='text-1'");?></td>
    </tr>  
    <tr>
      <th><?php echo $lang->category->readonly;?></th>
      <td><?php echo html::radio('readonly', $lang->category->readonlyList, $category->readonly);?></td>
    </tr>  
    <?php endif;?>
    <tr><td></td><td><?php echo html::submitButton() . html::hidden('type', $category->type);?></td></tr>
  </table>
</form>
<?php if(isset($pageJS)) js::execute($pageJS);?>
