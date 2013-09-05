<?php
$treeMenu = $this->tree->getTreeMenu('blog', '', 0, array('treeModel', 'createBrowseLink'));
?>
<div class='col-md-3'>
  <div class='box widget radius'> 
    <h4 class='title'><?php echo $lang->categoryMenu;?></h4>
    <?php echo $treeMenu;?>
  </div>
</div>
