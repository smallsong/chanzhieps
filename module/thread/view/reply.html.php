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
    <td id='<?php echo $reply->id;?>'><?php echo $reply->content;?></td>
  </tr>
  <tr> 
    <td class='speaker'></td>
    <td class='a-right'>
      <div class='f-left'><?php $this->reply->printFiles($reply, $this->thread->canManage($board->moderators));?></div>
      <div class='f-right'>
        <?php 
        if($reply->editor) printf($lang->thread->lblEdited, $reply->editor, $reply->editedDate);
        if($this->app->user->account != 'guest')
        {
            echo html::a('#reply', $lang->reply->common);
            if($this->thread->canEdit($board, $reply->author)) echo html::a($this->createLink('reply', 'edit',   "replyID=$reply->id"), $lang->edit);
            //if($this->thread->canManage($board->moderators)) echo html::a($this->createLink('reply', 'delete', "replyID=$reply->id"), $lang->delete, '', "class='deleter'");
        }
        else
        {
            echo html::a($this->createLink('user', 'login', 'referer=' . helper::safe64Encode($this->app->getURI(true))) . '#reply', $lang->reply->common);;
        }
        ?>
      </div>  
    </td>
  </tr>
</table>
<?php endforeach;?>

<?php $pager->show('right', 'short');?>

<?php if($this->session->user->account != 'guest'):?>
  <form method='post' enctype='multipart/form-data' id='reply' action='<?php echo $this->createLink('reply', 'post', "thread=$thread->id");?>'>
    <?php 
    echo "<div class='w-p100'>" . html::textarea('content', '', "rows='10' class='area-1'") . "</div>";
    echo "<div class='c-both'></div>";
    echo $this->fetch('file', 'buildForm');
    echo html::submitButton();

    echo html::hidden('recTotal',   $pager->recTotal);
    echo html::hidden('recPerPage', $pager->recPerPage);
    echo html::hidden('pageID',     $pager->pageTotal);
    ?>
  </form>
<?php endif;?>
