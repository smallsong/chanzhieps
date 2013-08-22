<?php 
include '../../common/view/header.html.php'; 
include '../../common/view/treeview.html.php'; 

/* set categoryPath for topNav highlight. */
js::set('path',  json_encode($product->path));

js::set('productID', $product->id);
?>
<?php $common->printPositionBar($category, $product);?>
<div class='row'>
  <?php include '../../common/view/side.html.php'; ?>
  <div class='col-md-9'>
    <div class='widget radius'>
      <div class='content'>
        <h2 class='a-center'><?php echo $product->name;?></h2>
        <p><?php echo $product->content;?></p>
        <div class='f-left'><?php $this->loadModel('file')->printFiles($product->files);?></div>
      </div>
    </div>
    <div id='commentBox'></div>
    <?php echo html::a('', '', '', "name='comment'");?>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>
