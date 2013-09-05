<?php
/**
 * The create view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php 
$type = $this->get->type;
if(empty($type) or $type == 'html') unset($config->block->editor);
?>
<?php include '../../common/view/kindeditor.html.php';?>
<form method='post' target='hiddenwin'>
<table align='center' class='table-1'>
  <caption><?php echo $lang->block->add;?></caption>
  <tr>
    <th class='w-id'><?php echo $lang->block->type;?></th>
    <td><?php echo html::select('type', $lang->block->typeList, $type, 'class=select-3');?></td>
  </tr>
  <tr>
    <th><?php echo $lang->block->title;?></th>
    <td><?php echo html::input('title', '', 'class=text-1');?></td>
  </tr>
  <tr>
    <th><?php echo $lang->block->content;?></th>
    <td><?php echo html::textarea('content', '', 'rows=20 class=area-1');?></td>
  </tr>
  <tr>
    <td colspan='2' class='a-center'><?php echo html::submitButton();?></td>
  </tr>
</table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
