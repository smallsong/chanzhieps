<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <?php include './side.html.php';?>
  <div class='col-md-9'>
    <table class='table table-bordered  table-hover' id='messages'>
    <caption><?php echo $lang->user->message;?></caption>
      <tr>
        <th class='w-10px'><input type='checkbox' id='selectAll'></th>
        <th class='w-50px'><?php echo $lang->message->from;?></th>
        <th class='w-100px'><?php echo $lang->message->time;?></th>
        <th><?php echo $lang->message->content;?></th>
        <th class='w-50px'><?php echo $lang->message->status;?></th>
        <th class='w-80px'><?php echo $lang->actions;?></th>
      </tr>
      <form method='post' target='hiddenwin' action="<?php echo $this->createLink('message', 'batchDelete');?>">
      <?php foreach($messages as $message):?>
      <tr class='a-center'>
        <td><input type='checkbox' name='messages[]' value="<?php echo $message->id?>" /></td>
        <td><?php echo $message->from;?></td>
        <td><?php echo substr($message->time, 5);?></td>
        <td class='a-left'><?php echo $message->content;?></td>
        <td><?php echo $lang->message->statusList[$message->readed];?></td>
        <td><?php echo html::a($this->createLink('message', 'view', "message=$message->id"), $lang->message->view);?></td>
      </tr>
      <?php endforeach;?>
      <tr>
        <td colspan='6'>
          <?php
          if($messages) echo html::submitButton($lang->message->delSelect);
          $pager->show();
          ?>
        </td>
      </tr>
      </form>
    </table>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
