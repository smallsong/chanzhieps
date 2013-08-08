<?php
/**
 * The post view file of thread module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>

<?php $common->printPositionBar($board);?>

<form method='post' id="ajaxForm" enctype='multipart/form-data'>
  <table class='table table-bordered table-form'>
    <caption><?php echo $board->name;?></caption>
    <tr>
      <th class='w-100px'><?php echo $lang->thread->title;?></th>
      <td><?php echo html::input('title', '', "class='text-1'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->thread->content;?></th>
      <td><?php echo html::textarea('content', '', "rows='15' class='area-1'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->thread->file;?></th>
      <td><?php echo $this->fetch('file', 'buildForm');?></td>
    </tr>
    <tr>
      <th></th>
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.html.php';?>
