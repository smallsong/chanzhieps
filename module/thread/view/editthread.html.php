<?php
/**
 * The edit thread view file of block module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php if($this->thread->hasManagePriv($this->app->user->account, $board->owners)) $config->thread->editor->editthread['tools'] = 'fullTools'; ?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php $common->printPositionBar($board, $thread);?>
<div class='row-fluid'>
      <form method='post' id='ajaxForm' enctype='multipart/form-data'>
      <table class='table table-bordered'>
        <caption class='caption-bold'><?php echo $lang->thread->editThread . $lang->colon . $thread->title;?></caption>
        <tr>
          <th class='w-100px'><?php echo $lang->thread->title;?></th>
          <td><?php echo html::input('title', $thread->title, 'style="width:90%"');?></td>
        </tr>
        <tr>
          <th><?php echo $lang->thread->content;?></th>
          <td><?php echo html::textarea('content', htmlspecialchars($thread->content), "rows=20 class='area-1' tabindex=1");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->thread->file;?></th>
          <td>
          <?php
          if($thread->files)
          {
              foreach($thread->files as $file) echo html::a($file->fullURL, $file->title . '.' . $file->extension, '_blank') . ' ' . html::linkButton('Ｘ', inlink('deleteFile', "fileID=$file->id&objectID=$thread->id&objectType=thread"), 'btn', '', 'hiddenwin');
          }
          echo $this->fetch('file', 'buildForm');
          ?>
          </td>
        </tr>
        <tr><td colspan='2' align='center'><?php echo html::submitButton('', 'tabindex=2') . html::backButton();?></td></tr>
      </table>
      </form>
</div>
<?php include '../../common/view/footer.html.php';?>
