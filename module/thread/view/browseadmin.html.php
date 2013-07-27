<?php include '../../common/view/header.admin.html.php'; ?>
<!-- <h2><?php $config->requestType = 'PATH_INFO';?></h2> -->
<table class='table'>
  
<!--   <caption>
    <div class='f-left'><?php echo $lang->thread->browse;?></div>
    <div class='f-right'><?php if($board) echo html::a($this->createLink('thread', 'post', "boardID=$board->id"), $lang->forum->post, '_blank');?></div>
  </caption> -->
  <tr>
    <th><?php echo $lang->thread->id;?></th>
    <th><?php echo $lang->thread->title;?></th>
    <th><?php echo $lang->thread->author;?></th>
    <th><?php echo $lang->thread->postedDate;?></th>
    <th><?php echo $lang->thread->views;?></th>
    <th><?php echo $lang->thread->replies;?></th>
    <th colspan='2'><?php echo $lang->thread->lastReply;?></th>
  </tr>  
  <?php foreach($threads as $thread):?>
  <tr class='a-center'>
    <td class='w-30px'><?php echo $thread->id;?></td>
    <td class='a-left'><?php echo html::a($this->createLink('thread', 'view', "id=$thread->id"), $thread->title, '_blank');?></td>
    <td class='a-left w-50px'><?php echo $thread->author;?></td>
    <td class='w-100px'><?php echo substr($thread->addedDate, 5, -3);?></td>
    <td class='w-30px'><?php echo $thread->views;?></td>
    <td class='w-30px'><?php echo $thread->replies;?></td>
    <td class='w-150px a-left'><?php if($thread->replies) echo substr($thread->lastRepliedDate, 5, -3) . ' ' . $thread->lastRepliedBy;?></td>  
  </tr>  
  <?php endforeach;?>
  <?php $config->requestType = 'GET';?>
  <tr><td colspan='8'><?php $pager->show();?></td></tr>
</table>
<?php include '../../common/view/footer.admin.html.php'; ?>
