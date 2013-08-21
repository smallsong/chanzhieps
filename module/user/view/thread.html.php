<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <?php include('side.html.php')?>
  <div class='col-md-9'>
    <table class='table table-bordered table-hover'>
      <thead>
        <caption><?php echo $lang->user->thread;?></caption>
        <tr class='a-center'>
          <th><?php echo $lang->thread->title;?></th>
          <th><?php echo $lang->thread->postedDate;?></th>
          <th><?php echo $lang->thread->views;?></th>
          <th><?php echo $lang->thread->replies;?></th>
          <th colspan='2'><?php echo $lang->thread->lastReply;?></th>
        </tr>  
      </thead>
      <tbody>
        <?php foreach($threads as $thread):?>
        <tr class='a-center'>
          <td class='a-left'><?php echo html::a($this->createLink('thread', 'view', "id=$thread->id"), $thread->title, '_blank');?></td>
          <td class='w-100px'><?php echo substr($thread->addedDate, 5, -3);?></td>
          <td class='w-30px'><?php echo $thread->views;?></td>
          <td class='w-30px'><?php echo $thread->replies;?></td>
          <td class='w-150px a-left'><?php if($thread->replies) echo substr($thread->repliedDate, 5, -3) . ' ' . $thread->repliedBy;?></td>  
        </tr>  
        <?php endforeach;?>
      </tbody>
      <tfoot><tr><td colspan='5'><?php $pager->show('right', 'short');?></td></tr></tfoot>
    </table>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
