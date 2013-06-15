<table class='table-1 f-12px' align='center'>
  <caption><?php echo $lang->file->browse;?></caption>
  <tr>
    <th><?php echo $lang->file->id;?></th>
    <th><?php echo $lang->file->title;?></th>
    <th><?php echo $lang->file->extension;?></th>
    <th><?php echo $lang->file->size;?></th>
    <th><?php echo $lang->file->addedDate;?></th>
    <th><?php echo $lang->file->score;?></th>
    <th><?php echo $lang->file->downloads;?></th>
    <th><?php echo $lang->file->download;?></th>
  </tr>
  <?php $i = 1;?>
  <?php foreach($files as $file):?>
  <tr class='a-center'>
    <td><?php echo $i ++;?></td>
    <th class='a-left'><?php echo html::a($this->createLink('file', 'download', "id=$file->id"), $file->title, '_blank');?></th>
    <td><?php echo $file->extension;?></td>
    <td><?php echo $file->size;?></td>
    <td><?php echo $file->addedDate;?></td>
    <td><?php echo $file->score;?>
    <td><?php echo $file->downloads;?></td>
    <td><?php echo html::a($this->createLink('file', 'download', "id=$file->id"), $lang->file->download, '_blank', 'class="red"');?></td>
  </tr>
  <?php endforeach;?>
  <?php if($app->user->account != 'guest'):?>
  <tr><td colspan='9'><?php printf($lang->file->lblInfo, $this->loadModel('user')->getByAccount($app->user->account)->score);?></td></tr>
  <?php endif;?>
</table>

