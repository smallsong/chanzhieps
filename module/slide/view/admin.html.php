<?php
/**
 * The admin browse view file of slide module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan<guanxiying@xirangit.com>
 * @package     slide
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<form id='sortForm' action='<?php echo inLink('sort')?>' method='post'>
  <table class='table table-hover table-bordered table-striped'>
    <caption>
      <div class='f-left'><?php echo $lang->slide->admin;?></div>
      <div class='f-right'><?php echo html::a($this->inlink('create'), $lang->slide->create, '', "class='btn btn-inverse'");?></div>
    </caption>
    <thead>
      <tr class='a-center'>
        <th class='w-id'><?php echo $lang->slide->sort;?></th>
        <th class='w-100px'><?php echo $lang->slide->image;?></th>
        <th class='w-p20'><?php echo $lang->slide->title;?></th>
        <th><?php echo $lang->slide->summary;?></th>
        <th class='w-100px'><?php echo $lang->slide->label;?></th>
        <th class='w-150px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($slides as  $key => $slide):?>
      <tr class='a-left v-middle'>
        <td class='a-center'>
          <i class='icon-arrow-up'></i>
          <i class='icon-arrow-down'></i>            
          <?php echo html::hidden("order[{$slide->id}]", $key);?>
        </td>
        <td class='a-center'><?php echo html::a($slide->image, html::image($slide->image, "class='image-small'"), '_blank');?></td>
        <td><?php echo $slide->title;?></td>
        <td><?php echo $slide->summary;?></td>
        <td><?php echo $slide->label;?></td>
        <td class='a-center'>
          <?php
          echo html::a($this->createLink('slide', 'edit', "id=$slide->id"), $lang->edit, '');
          echo html::a($this->createLink('slide', 'delete', "id=$slide->id"), $lang->delete, '', "class='deleter'");
          ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot>
    <tr><td colspan='6'><?php echo html::submitButton($this->lang->slide->saveSort);?></td></tr> 
    </tfoot>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
