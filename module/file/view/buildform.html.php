<div id='fileform'>
  <?php for($i = 0; $i < $fileCount; $i ++):?>
  <input type='file' name='files[]' id="file<?php echo $i;?>"  tabindex='-1' />
  <label id='label<?php echo $i;?>' tabindex='-1'><?php echo $lang->file->label;?></label>
  <input type='text' id='label<?php echo $i;?>' name='labels[]' class='text-3' tabindex='-1' /><br />
  <?php endfor;?>
</div>
