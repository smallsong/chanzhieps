<?php
/**
 * The edit reply view file of block module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php if($this->thread->hasManagePriv($this->app->user->account, $board->owners)) $config->thread->editor->editreply['tools'] = 'fullTools'; ?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php $common->printPositionBar($board, $thread);?>
<div class='row-fluid'>
      <form method='post' id='ajaxForm' enctype='multipart/form-data'>
      <table class='table table-bordered'>
        <caption class='caption-bold'><?php echo $lang->thread->editReply;?></caption>
        <tr>
          <th><?php echo $lang->reply->content;?></th>
          <td>
            <?php echo html::textarea('content', htmlspecialchars($reply->content), "rows=20 class='area-1' tabindex=1");?>
            <div id="yz"></div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->thread->file;?></th>
          <td>
          <?php
          if($reply->files)
          {
              foreach($reply->files as $file) echo html::a($file->fullURL, $file->title . '.' . $file->extension, '_blank') . ' ' . html::linkButton('Ｘ', inlink('deleteFile', "fileID=$file->id&objectID=$reply->id&objectType=reply"), 'btn', '', 'hiddenwin');
          }
          echo $this->fetch('file', 'buildForm');
          ?>
          </td>
        </tr>
        <tr><td colspan='2' align='center'><?php echo html::submitButton('', 'onclick="return checkGarbage(\'content\')" tabindex=2') . html::backButton();?></td></tr>
      </table>
      </form>
    <div id='zbyz' class='hidden'><?php $this->loadModel('comment')->setVerify();?></div>
</div>
<?php include '../../common/view/footer.html.php';?>
