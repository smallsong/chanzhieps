<?php include '../../common/view/header.admin.html.php'; ?>
<table class='table-1' align='center'>
  <caption><?php echo $lang->file->browse;?></caption>
  <tr>
    <th><?php echo $lang->file->id;?></th>
    <th><?php echo $lang->file->title;?></th>
    <th><?php echo $lang->file->pathname;?></th>
    <th><?php echo $lang->file->extension;?></th>
    <th><?php echo $lang->file->size;?></th>
    <th><?php echo $lang->file->addedBy;?></th>
    <th><?php echo $lang->file->addedDate;?></th>
    <th><?php echo $lang->file->public;?></th>
    <th><?php echo $lang->file->downloads;?></th>
    <th><?php echo $lang->actions;?></th>
  </tr>
  <?php foreach($files as $file):?>
  <tr class='a-center'>
    <td><?php echo $file->id;?></td>
    <td class='a-left'><?php echo $file->title;?></td>
    <td><?php echo html::a(inlink('download', "id=$file->id"), $file->pathname, '_blank');?></td>
    <td><?php echo $file->extension;?></td>
    <td><?php echo $file->size;?></td>
    <td><?php echo $file->addedBy;?></td>
    <td><?php echo $file->addedDate;?></td>
    <td><?php echo $lang->file->publics[$file->public];?></td>
    <td><?php echo $file->downloads;?></td>
    <td>
    <?php
    if($file->public)
    {
        echo html::a(inlink('deny',  "id=$file->id"), $lang->file->deny, 'hiddenwin');
    }
    else
    {
        echo html::a(inlink('allow', "id=$file->id"), $lang->file->allow, 'hiddenwin');
    }
    ?>
    </td>
  </tr>
  <?php endforeach;?>
</table>
<form method='post' enctype='multipart/form-data' target='hiddenwin' 
action='<?php echo inlink('upload', "objectType=$objectType&objectID=$objectID");?>'>
<table class='table-1' align='center'>
  <tr>
    <td><?php echo $lang->file->upload;?></td>
    <td><?php echo $this->fetch('file', 'buildForm');?></td>
  </tr>
  <tr><td colspan='2' class='a-center'><?php echo html::submitButton();?></td></tr>
</table>
</form>
<?php include '../../common/view/footer.admin.html.php'; ?>
