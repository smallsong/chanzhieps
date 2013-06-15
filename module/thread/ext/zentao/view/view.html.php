<?php if($this->thread->hasManagePriv($this->app->user->account, $board->owners)) $config->thread->editor->view['tools'] = 'fullTools'; ?>
<?php include '../../../../common/view/header.html.php'; ?>
<?php include '../../../../common/view/kindeditor.html.php'; ?>
<style>#footer{margin-top:18px;}</style>
<?php $common->printPositionBar($board, $thread);?>
<div class='row'>
  <div class='u-1 cont' id='thread'>
    <table class='table-1'>
      <caption class='caption-bold'><?php echo $thread->addedDate . " " . $thread->title;?></caption>
      <tr valign='top'>
        <td class='user'>
          <?php
          $user = $users[$thread->author];
          $user->last = substr($user->last, 5, -3);
          $kindUser   = $user->love ? "<span class='loveicon' title='{$lang->user->love}'></span>" : '';
          $user       = $this->user->switchLevel($user);
          $userLevel  = "<span class='secticon{$user->sect}'></span><span class='level{$user->level}sect{$user->sect}' title='{$lang->user->levelList{$user->level}->sect[$user->sect]}'></span>";
          $userLevel  = $user->account == $this->app->user->account ? html::a($this->createLink('user', 'profile'), $userLevel) : $userLevel;
          printf($lang->thread->lblUser, $user->account, $kindUser, $user->visits, $user->join, $user->last, $user->score, $userLevel);
          ?>
        </td>
        <td id=<?php echo $thread->id;?>>
        <?php
        echo $thread->content;
        if(isset($thread->files)) $this->thread->printFiles($thread->id, $thread->files, 'thread', $this->thread->hasManagePriv($this->app->user->account, $board->owners));
        ?>
        </td>
        <td class='w-10px'><?php if(isset($thread->scoreSum)) printf($lang->thread->scoreSum, $thread->scoreSum);?></td>
      </tr>
      <tr> 
        <td class='user'></td>
        <td colspan='2' class='a-right'>
          <?php 
          if($thread->editor) printf($lang->thread->lblEdited, $thread->editor, $thread->editedDate);
          if($this->thread->hasManagePriv($this->app->user->account, $board->owners))
          {
              echo $lang->thread->sticks[$thread->stick];
              foreach($lang->thread->sticks as $stick => $label)
              {
                  echo html::a(inlink('stick', "thread=$thread->id&stick=$stick"), $label, 'hiddenwin');
              }
              if(!$thread->readonly) echo html::a($this->createLink('ask','threadToAsk', "thread=$thread->id"), $lang->thread->toAsk);
          }

          if(!$board->readonly and !$thread->readonly)
          {
              if($this->app->user->account != 'guest')
              {
                  echo html::a('#reply', $lang->reply->common, '', "onclick='toReply($thread->id, \"$thread->author\")'");
                  if($this->thread->hasEditPriv($this->app->user->account, $board->owners, $thread->author)) echo html::a(inlink('editThread', "threadID=$thread->id"), $lang->edit);
                  if($this->thread->hasManagePriv($this->app->user->account, $board->owners))
                  {
                      echo html::a(inlink('hidePost',   "objectType=thread&objectID=$thread->id"), $lang->hide, 'hiddenwin');
                      echo html::a(inlink('deleteThread', "threadID=$thread->id"), $lang->delete, 'hiddenwin');
                      foreach($lang->thread->scores as $score => $label)
                      {
                          $account = helper::safe64Encode($thread->author);
                          echo html::a(inlink('addScore', "account=$account&object=thread&id={$thread->id}&score=$score"), $label, 'hiddenwin');
                      }
                  }
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
    <?php $i = 1 + ($pager->pageID - 1) * $pager->recPerPage;?>
    <?php foreach($thread->replies as $reply):?>
    <table class='table-1'>
      <caption class='caption-bold'>
        <div class='f-left'><?php echo $reply->addedDate;?></div>
        <div class='f-right'>#<?php echo $i++;?></div>
      </caption>
      <tr valign='top'>
        <td class='user'>
          <?php
          $user = $users[$reply->author];
          if(strlen($user->last) > 11) $user->last = substr($user->last, 5, -3);
          $kindUser   = $user->love ? "<span class='loveicon' title='{$lang->user->love}'></span>" : '';
          $user       = $this->user->switchLevel($user);
          $userLevel  = "<span class='secticon{$user->sect}'></span><span class='level{$user->level}sect{$user->sect}' title='{$lang->user->levelList{$user->level}->sect[$user->sect]}'></span>";
          $userLevel  = $user->account == $this->app->user->account ? html::a($this->createLink('user', 'profile'), $userLevel) : $userLevel;
          printf($lang->thread->lblUser, $user->account, $kindUser, $user->visits, $user->join, $user->last, $user->score, $userLevel);
          ?>
        </td>
        <td id=<?php echo $reply->id;?>>
        <?php
        echo $reply->content;
        if(isset($reply->files)) $this->thread->printFiles($reply->id, $reply->files, 'reply', $this->thread->hasManagePriv($this->app->user->account, $board->owners));
        ?>
        </td>
        <td class='w-10px'><?php if(isset($reply->scoreSum)) printf($lang->thread->scoreSum, $reply->scoreSum);?></td>
      </tr>
      <tr> 
        <td class='user'></td>
        <td colspan='2' class='a-right'>
          <?php 
          if($reply->editor) printf($lang->thread->lblEdited, $reply->editor, $reply->editedDate);
          if(!$board->readonly and !$thread->readonly)
          {
              if($this->app->user->account != 'guest')
              {
                  echo html::a('#reply', $lang->reply->common, '', "onclick='toReply($thread->id, \"$reply->author\")'");
                  if($this->thread->hasEditPriv($this->app->user->account, $board->owners, $reply->author)) echo html::a(inlink('editReply', "replyID=$reply->id"), $lang->edit);
                  if($this->thread->hasManagePriv($this->app->user->account, $board->owners))
                  {
                      echo html::a(inlink('hidePost',   "objectType=reply&objectID=$reply->id"), $lang->hide, 'hiddenwin');
                      echo html::a(inlink('deleteReply', "replyID=$reply->id"), $lang->delete, 'hiddenwin');
                      foreach($lang->thread->scores as $score => $label)
                      {
                          $account = helper::safe64Encode($reply->author);
                          echo html::a(inlink('addScore', "account=$account&object=reply&id={$reply->id}&score=$score"), $label, 'hiddenwin');
                      }
                  }
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
   <div class='f-right'><?php $pager->show();?></div>

   <?php if($this->session->user->account != 'guest' and !$board->readonly and !$thread->readonly):?>
     <form method='post' target='hiddenwin' name='reply' id='reply' enctype='multipart/form-data' action='<?php echo inlink('reply', "thread=$thread->id");?>'>
     <table class='table-1 border'>
       <caption class='caption-bold'><?php echo $lang->reply->common;?></caption>
       <tr>
         <td>
           <?php 
           echo html::textarea('content', '', "rows=10 class='area-1' tabindex=1");
           echo $this->fetch('file', 'buildForm');
           echo '<div id="yz"></div>';
           echo html::submitButton('', 'onclick="return checkGarbage(\'content\')" tabindex=2'). html::hidden('recTotal', $pager->recTotal).
               html::hidden('recPerPage', $pager->recPerPage). html::hidden('pageID', $pager->pageTotal);
           ?>
         </td>
       </tr>
     </table>
   </form>
   <?php endif;?>
   <div id='zbyz' class='hidden'><?php $this->loadModel('comment')->setVerify();?></div>
  </div>
</div>
<?php include '../../../../common/view/footer.html.php'; ?>
