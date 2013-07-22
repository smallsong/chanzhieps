<table class='table table-bordered'>
  <caption><?php echo $lang->file->browse;?></caption>
  <tr>
    <th><?php echo $lang->file->id;?></th>
    <th><?php echo $lang->file->common;?></th>
    <th><?php echo $lang->file->extension;?></th>
    <th><?php echo $lang->file->size;?></th>
    <th><?php echo $lang->file->addedBy;?></th>
    <th><?php echo $lang->file->addedDate;?></th>
    <th><?php echo $lang->file->public;?></th>
    <th><?php echo $lang->file->downloads;?></th>
    <th><?php echo $lang->actions;?></th>
  </tr>
  <?php foreach($files as $file):?>
  <tr>
    <td><?php echo $file->id;?></td>
    <td>
    <?php
    if($file->isImage)
    {
        echo html::a(inlink('download', "id=$file->id"), html::image($file->smallURL, "class='adminList' title='{$file->title}'"), '_blank');
    }
    else
    {
        echo html::a(inlink('download', "id=$file->id"), "{$file->title}.{$file->extension}", '_blank');
    }
    ?>
    </td>
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
        echo html::a(inlink('deny',  "id=$file->id"), $lang->file->deny, '', 'class="deny"');
    }
    else
    {
        echo html::a(inlink('allow', "id=$file->id"), $lang->file->allow, '', 'class="allow"');
    }
    echo html::a(inlink('delete', "id=$file->id"), $lang->delete, '', "class='delete'");
    ?>
    </td>
  </tr>
  <?php endforeach;?>
</table>
<form id="fileForm" method='post' class="form-inline" enctype='multipart/form-data' action='<?php echo inlink('upload', "objectType=$objectType&objectID=$objectID");?>'>
<table class='table table-bordered table-form'>
  <tr>
    <td><?php echo $lang->file->upload;?></td>
    <td><?php echo $this->fetch('file', 'buildForm');?></td>
  </tr>
  <tr><td colspan='2' class='a-center'><?php echo html::submitButton();?></td></tr>
</table>
</form>
<script>
$(document).ready(function(){   
    $.ajaxForm('#fileForm', function(data) { ajaxWinReload(); }); 
    $('a.deny, a.allow').click(function(data){
        $.getJSON($(this).attr('href'), 
            function(data) 
            {
                if(data.result=='success')
                {
                    ajaxWinReload();
                }
                else
                {
                    alert(data.message);
                }
            }
        );
        return false;
    });
});
</script>
