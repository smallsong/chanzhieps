<?php
/**
 * The edit view file of reply module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     reply
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php if($this->thread->hasManagePriv($this->app->user->account, $board->owners)) $config->thread->editor->editreply['tools'] = 'fullTools'; ?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php $common->printPositionBar($board, $thread);?>
<form method='post' id='ajaxForm' enctype='multipart/form-data'>
<table class='table table-form'>
  <caption><?php echo $lang->thread->editReply;?></caption>
  <tr>
    <th class='w-100px'><?php echo $lang->reply->content;?></th>
    <td>
      <?php echo html::textarea('content', htmlspecialchars($reply->content), "rows=20 class='area-1' tabindex=1");?>
    </td>
  </tr>
  <tr>
    <th><?php echo $lang->thread->file;?></th>
    <td>
    <?php
    if($reply->files)
    {
        foreach($reply->files as $file) echo html::a($file->fullURL, $file->title . '.' . $file->extension, '_blank') . ' ' . html::linkButton('Ｘ', inlink('deleteFile', "fileID=$file->id&objectID=$reply->id&objectType=reply"), 'btn btn-default', '', 'hiddenwin');
    }
    echo $this->fetch('file', 'buildForm');
    ?>
    </td>
  </tr>
  <tr>
    <th></th>
    <td colspan='2' align='center'><?php echo html::submitButton('', 'btn btn-primary', 'onclick="return checkGarbage(\'content\')" tabindex=2' ) . html::backButton();?></td></tr>
</table>
</form>
<?php include '../../common/view/footer.html.php';?>
