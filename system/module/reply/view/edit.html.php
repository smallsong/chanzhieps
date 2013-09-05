<?php
/**
 * The edit reply view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php $common->printPositionBar($board, $thread);?>

<form method='post' id='ajaxForm' enctype='multipart/form-data'>
  <table class='table table-form'>
    <caption><?php echo $lang->reply->edit;?></caption>
    <tr>
      <th class='w-100px'><?php echo $lang->reply->content;?></th>
      <td><?php echo html::textarea('content', $reply->content, "rows='15' class='area-1'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->thread->file;?></th>
      <td>
        <?php
        $this->reply->printFiles($reply, $canManage = true);
        echo $this->fetch('file', 'buildForm');
        ?>
      </td>
    </tr>
    <tr>
      <th></th>
      <td colspan='2'><?php echo html::submitButton() . html::backButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.html.php';?>
