<?php if($config->features->tree):?>
<div class='box-title'><?php echo $lang->articleTree;?></div>
<div class='box-content'><?php echo $articleTree;?></div>
<?php endif;?>
<?php $this->block->printBlock($layouts, 'right');?>
