<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <?php include 'side.html.php';?>
  <div class='col-md-9'>
    <table class='table table-bordered'>
      <thead>
        <caption><?php echo $lang->user->reply;?></caption>
        <tr class='a-center'>
          <th><?php echo $lang->thread->common;?></th>
          <th><?php echo $lang->reply->addedDate;?></th>
        </tr>  
      </thead>
      <tbody>
        <?php foreach($replies as $reply):?>
        <tr>
          <td><?php echo html::a($this->createLink('thread', 'view', "id=$reply->thread") . "#$reply->id", $reply->title . " <i>(#$reply->id)</i>", '_blank');?></td>
          <td class='w-150px'><?php echo $reply->addedDate;?></td>
        </tr>  
        <?php endforeach;?>
      </tbody>
      <tfoot><tr><td colspan='2'><?php $pager->show('right', 'short');?></td></tr></tfoot>
    </table>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
