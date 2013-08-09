<?php include '../../common/view/header.admin.html.php'; ?>
<table class='table table-hover table-bordered table-striped'>
  <caption><?php echo $lang->forum->threadList;?></caption>
  <thead>
    <tr class='a-center'>
      <th class='w-id'><?php echo $lang->thread->id;?></th>
      <th><?php echo $lang->thread->title;?></th>
      <th><?php echo $lang->thread->author;?></th>
      <th><?php echo $lang->thread->postedDate;?></th>
      <th><?php echo $lang->thread->views;?></th>
      <th><?php echo $lang->thread->replies;?></th>
      <th><?php echo $lang->thread->lastReply;?></th>
      <th class='w-80px a-center'><?php echo $lang->actions;?></th>
    </tr>  
  </thead>
  <tbody>
    <?php foreach($threads as $thread):?>
    <tr class='a-center'>
      <th><?php echo $thread->id;?></th>
      <td class='a-left'>
        <?php
        $iconRoot = $themeRoot . 'default/images/forum/';
        echo $thread->isNew ? "<span class='new-board'>&nbsp;</span>" : "<span class='common-board'>&nbsp;</span>";
        echo html::a(commonModel::createFrontLink('thread', 'view', "threadID=$thread->id"), $thread->title, '_blank');
        ?>
      </td>
      <td class='w-50px'><?php echo $thread->author;?></td>
      <td class='w-100px'><?php echo substr($thread->addedDate, 5, -3);?></td>
      <td class='w-30px'><?php echo $thread->views;?></td>
      <td class='w-30px'><?php echo $thread->replies;?></td>
      <td class='w-150px a-left'><?php if($thread->replies) echo substr($thread->lastRepliedDate, 5, -3) . ' ' . $thread->lastRepliedBy;?></td>  
      <td>
        <?php echo html::a($this->createLink('thread', 'delete', "threadID=$thread->id"), $lang->delete, '', "class='deleter'"); ?>
      </td>
    </tr>  
    <?php endforeach;?>
  </tbody>
  <?php $config->requestType = 'GET';?>
  <tfoot><tr><td colspan='8'><?php $pager->show();?></td></tr></tfoot>
</table>
<?php include '../../common/view/footer.admin.html.php'; ?>
