<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <?php include 'side.html.php';?>
  <div class='span9'>
      <table class='table'>
      <caption><?php echo $lang->user->reply;?></caption>
        <tr>
          <th><?php echo $lang->reply->addedDate;?></th>
          <th><?php echo $lang->thread->common;?></th>
        </tr>  
        <?php foreach($replies as $reply):?>
        <tr class='a-center'>
          <td class='w-230px'><?php echo $reply->addedDate;?></td>
          <td class='a-left'><?php echo html::a($this->createLink('thread', 'view', "id=$reply->thread") . "#$reply->id", $reply->title . " <i>(#$reply->id)</i>", '_blank');?></td>
        </tr>  
        <?php endforeach;?>
        <tr><td colspan='8'><?php $pager->show();?></td></tr>
      </table>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
