<?php include '../../common/view/header.html.php'; ?>
<?php include '../../common/view/treeview.html.php'; ?>
<?php $common->printPositionBar($board);?>
<table class='table table-form table-hover table-striped'>
  <caption>
    <div class='f-left'>
      <?php 
      echo $board->name; 
      if($board->owners) printf($lang->forum->lblOwner, trim($board->owners, ','));
      ?>
    </div>
    <div class='f-right'><?php if(!$board->readonly) echo html::a($this->createLink('thread', 'post', "boardID=$board->id"), $lang->forum->post);?></div>
  </caption>
  <thead>
    <tr class='a-center'>
      <th class='a-center' colspan='2'><?php echo $lang->thread->title;?></th>
      <th><?php echo $lang->thread->author;?></th>
      <th><?php echo $lang->thread->postedDate;?></th>
      <th><?php echo $lang->thread->views;?></th>
      <th><?php echo $lang->thread->replies;?></th>
      <th colspan='2'><?php echo $lang->thread->lastReply;?></th>
    </tr>  
  </thead>
  <tbody>
    <?php foreach($stickThreads as $thread):?>
    <tr class='a-center'>
      <td class='w-10px red'><span class='sticky-thread'>&nbsp;</span></td>
      <td class='a-left'><?php echo "<span class=red>{$lang->thread->stick}</span>" . $lang->arrow . html::a($this->createLink('thread', 'view', "id=$thread->id"), $thread->title);?></td>
      <td class='a-left w-50px'><?php echo $thread->author;?></td>
      <td class='w-100px'><?php echo substr($thread->addedDate, 5, -3);?></td>
      <td class='w-30px'><?php echo $thread->views;?></td>
      <td class='w-30px'><?php echo $thread->replies;?></td>
      <td class='w-150px'><?php if($thread->replies) echo substr($thread->lastRepliedDate, 5, -3) . ' ' . $thread->lastRepliedBy;?></td>  
    </tr>  
    <?php unset($threads[$thread->id]);?>
    <?php endforeach;?>

    <?php foreach($threads as $thread):?>
    <tr class='a-center'>
      <td class='w-10px'><?php echo $thread->isNew ? "<span class='new-board'>&nbsp;</span>" : "<span class='common-board'>&nbsp;</span>";?></td>
      <td class='a-left'><?php echo html::a($this->createLink('thread', 'view', "id=$thread->id"), $thread->title);?></td>
      <td class='a-left w-50px'><?php echo $thread->author;?></td>
      <td class='w-100px'><?php echo substr($thread->addedDate, 5, -3);?></td>
      <td class='w-30px'><?php echo $thread->views;?></td>
      <td class='w-30px'><?php echo $thread->replies;?></td>
      <td class='w-150px'><?php if($thread->replies) echo substr($thread->lastRepliedDate, 5, -3) . ' ' . $thread->lastRepliedBy;?></td>  
    </tr>  
    <?php endforeach;?>
  </tbody>
  
  <tfoot><tr><td colspan='8'><?php $pager->show();?></td></tr></tfoot>
</table>
<?php include '../../common/view/footer.html.php'; ?>
