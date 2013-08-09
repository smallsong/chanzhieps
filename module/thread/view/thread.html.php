<table class='table table-form'>
  <caption><?php echo $thread->addedDate . " " . $thread->title;?></caption>
  <tbody>
    <tr>
      <td class='speaker'>
        <?php
        $speaker = $speakers[$thread->author];
        printf($lang->thread->lblSpeaker, $speaker->account, $speaker->visits, $speaker->shortJoin, $speaker->shortLast);
        ?>
      </td>
      <td id=<?php echo $thread->id;?>><?php echo $thread->content;?></td>
    </tr>
  </tbody>
  <tfoot>
    <tr> 
      <td class='speaker'></td>
      <td class='a-right' id='manageBox'>
        <div class='f-left'><?php $this->thread->printFiles($thread, $this->thread->canManage($board->moderators));?></div>
        <div id='manageMenu'>
          <?php 
          if($thread->editor) printf($lang->thread->lblEdited, $thread->editor, $thread->editedDate);
          if($this->thread->canManage($board->moderators))
          {
              echo $lang->thread->sticks[$thread->stick] . ' ';
              foreach($lang->thread->sticks as $stick => $label)
              {
                  if($thread->stick != $stick) echo html::a(inlink('stick', "thread=$thread->id&stick=$stick"), $label, '', "class='jsoner'");
              }
          }

          if($this->app->user->account != 'guest')
          {
              echo html::a('#reply', $lang->reply->common);
              if($this->thread->canEdit($board->moderators, $thread->author)) echo html::a(inlink('edit', "threadID=$thread->id"), $lang->edit);
              if($this->thread->canManage($board->moderators)) echo html::a(inlink('delete', "threadID=$thread->id"), $lang->delete, '', 'class="deleter"');
          }    
          else
          {
              echo html::a($this->createLink('user', 'login', 'referer=' . helper::safe64Encode($this->app->getURI(true))) . '#reply', $lang->reply->common);;
          }
          ?>
        </div>
      </td>
    </tr>
  </tfoot>
</table>