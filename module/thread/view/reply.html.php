<?php $i = 1 + ($pager->pageID - 1) * $pager->recPerPage;?>
<?php foreach($replies as $reply):?>
<table class='table table-form'>
  <caption>
    <div class='f-left'><?php echo $reply->addedDate;?></div>
    <div class='f-right'>#<?php echo $i++;?></div>
  </caption>
  <tr>
    <td class='speaker'>
      <?php
      $speaker = $speakers[$reply->author];
      printf($lang->thread->lblSpeaker, $speaker->account, $speaker->visits, $speaker->shortJoin, $speaker->shortLast);
      ?>
    </td>
    <td id=<?php echo $reply->id;?>>
      <?php
      echo $reply->content;
      $this->reply->printFiles($reply);
      ?>
    </td>
  </tr>
  <tr> 
    <td class='speaker'></td>
    <td class='a-right'>
      <?php 
      if($reply->editor) printf($lang->thread->lblEdited, $reply->editor, $reply->editedDate);
      if($this->app->user->account != 'guest')
      {
          echo html::a('#reply', $lang->reply->common);
          if($this->thread->canEdit($board, $reply->author)) echo html::a(inlink('edit', "replyID=$reply->id"), $lang->edit);
          if($this->thread->canManage($board->moderators)) echo html::a(inlink('delete', "replyID=$reply->id"), $lang->delete, '', 'class="deleter"');
      }
      else
      {
          echo html::a($this->createLink('user', 'login', 'referer=' . helper::safe64Encode($this->app->getURI(true))) . '#reply', $lang->reply->common);;
      }
      ?>
    </td>
  </tr>
</table>
<?php endforeach;?>

<div class='mb-10px mt-10px'><?php $pager->show('right', 'short');?></div>
<div style="clear: both"></div>
<?php if($this->session->user->account != 'guest'):?>
  <form method='post' enctype='multipart/form-data' id='reply' action='<?php echo $this->createLink('reply', 'post', "thread=$thread->id");?>'>
    <?php 
    echo html::textarea('content', '', "rows=10 class='threadEditor'");
    echo $this->fetch('file', 'buildForm');
    echo '<br />';
    echo html::submitButton('', 'btn btn-primary', 'onclick="return checkGarbage(\'content\')" tabindex=2 '). html::hidden('recTotal', $pager->recTotal). html::hidden('recPerPage', $pager->recPerPage). html::hidden('pageID', $pager->pageTotal);
    ?>
  </form>
<?php endif;?>
