<?php include '../../common/view/header.html.php'; ?>
<?php include '../../common/view/kindeditor.html.php'; ?>
<?php $common->printPositionBar($board, $thread);?>
<table class='table table-form'>
  <caption><?php echo $thread->addedDate . " " . $thread->title;?></caption>
  <tbody>
    <tr>
      <td class='user'>
        <?php
        $user = $users[$thread->author];
        $user->last = substr($user->last, 5, -3);
        $user->addedDate = substr($user->addedDate, 5, -3);
        printf($lang->thread->lblUser, $user->account, $user->visits, $user->addedDate, $user->last);
        ?>
      </td>
      <td id=<?php echo $thread->id;?>>
      <?php
      echo $thread->content;
      if(isset($thread->files)) $this->thread->printFiles($thread->id, $thread->files, 'thread', $this->thread->hasManagePriv($this->app->user->account, $board->owners));
      ?>
      </td>
    </tr>
  </tbody>
  <tfoot>
    <tr> 
      <td class='user'></td>
      <td class='a-right' id='manageBox'>
        <div id='manageMenu'>
          <?php 
          if($thread->editor) printf($lang->thread->lblEdited, $thread->editor, $thread->editedDate);
          if($this->thread->hasManagePriv($this->app->user->account, $board->owners))
          {
              echo $lang->thread->sticks[$thread->stick] . ' ';
              foreach($lang->thread->sticks as $stick => $label)
              {
                  if($thread->stick != $stick) echo html::a(inlink('stick', "thread=$thread->id&stick=$stick"), $label, '', "class='ajaxJSONER'");
              }
          }
          if(!$board->readonly)
          {
              if($this->app->user->account != 'guest')
              {
                  echo html::a('#reply', $lang->reply->common);
                  if($this->thread->hasEditPriv($this->app->user->account, $board->owners, $thread->author)) echo html::a(inlink('editThread', "threadID=$thread->id"), $lang->edit);
                  if($this->thread->hasManagePriv($this->app->user->account, $board->owners)) echo html::a(inlink('delete', "threadID=$thread->id"), $lang->delete, '', 'class="deleter"');
              }    
              else
              {
                  echo html::a($this->createLink('user', 'login', 'referer=' . helper::safe64Encode($this->app->getURI(true))) . '#reply', $lang->reply->common);;
              }
          }
          ?>
        </div>
      </td>
    </tr>
  </tfoot>
</table>
<?php $i = 1 + ($pager->pageID - 1) * $pager->recPerPage;?>
<?php foreach($thread->replies as $reply):?>
<table class='table table-form'>
  <caption>
    <div class='f-left'><?php echo $reply->addedDate;?></div>
    <div class='f-right'>#<?php echo $i++;?></div>
  </caption>
  <tr>
    <td class='user'>
      <?php
      $user = $users[$reply->author];
      if(strlen($user->last) > 11) $user->last = substr($user->last, 5, -3);
      printf($lang->thread->lblUser, $user->account, $user->visits, $user->addedDate, $user->last);
      ?>
    </td>
    <td id=<?php echo $reply->id;?>>
    <?php
    echo $reply->content;
    if(isset($reply->files)) $this->thread->printFiles($reply->id, $reply->files, 'reply', $this->thread->hasManagePriv($this->app->user->account, $board->owners));
    ?>
    </td>
  </tr>
  <tr> 
    <td class='user'></td>
    <td class='a-right'>
      <?php 
      if($reply->editor) printf($lang->thread->lblEdited, $reply->editor, $reply->editedDate);
      if(!$board->readonly)
      {
          if($this->app->user->account != 'guest')
          {
              echo html::a('#reply', $lang->reply->common);
              if($this->thread->hasEditPriv($this->app->user->account, $board->owners, $reply->author)) echo html::a(inlink('editReply', "replyID=$reply->id"), $lang->edit);
              if($this->thread->hasManagePriv($this->app->user->account, $board->owners)) echo html::a(inlink('deleteReply', "replyID=$reply->id"), $lang->delete, '', 'class="deleter"');
          }
          else
          {
              echo html::a($this->createLink('user', 'login', 'referer=' . helper::safe64Encode($this->app->getURI(true))) . '#reply', $lang->reply->common);;
          }
      }
      ?>
    </td>
  </tr>
</table>
<?php endforeach;?>
<div class='f-right mb-10px mt-10px'><?php $pager->show();?></div>
<div style="clear: both"></div>
<?php if($this->session->user->account != 'guest' and !$board->readonly):?>
  <form method='post' enctype='multipart/form-data' id='reply' action='<?php echo inlink('reply', "thread=$thread->id");?>'>
    <?php 
    echo html::textarea('content', '', "rows=10 class='threadEditor'");
    echo $this->fetch('file', 'buildForm');
    echo '<br />';
    echo html::submitButton('', 'btn', 'onclick="return checkGarbage(\'content\')" tabindex=2 '). html::hidden('recTotal', $pager->recTotal). html::hidden('recPerPage', $pager->recPerPage). html::hidden('pageID', $pager->pageTotal);
    ?>
  </form>
<?php endif;?>
<?php include '../../common/view/footer.html.php'; ?>
