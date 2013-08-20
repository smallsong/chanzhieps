<?php 
include '../../common/view/header.html.php';

$path = array_keys($category->pathNames);
js::set('path',  json_encode($path));

include '../../common/view/treeview.html.php';
?>
<?php echo $common->printPositionBar($category);?>
<div class='row'>
  <div class='col-md-9'>
    <div class='widget radius'>
      <h4><?php echo $category->name;?></h4>
      <ul class="media-list">
      <?php foreach($products as $product):?>
        <li class="media">
          <div class='media-body'>
            <h3 class='media-heading'><?php echo html::a(inlink('view', "id=$product->id"), $product->name);?></h3>
            <p>
              <?php 
              a($product);
              if(!empty($product->image))
              {
                  $title = $product->image->primary->title ? $product->image->primary->title : $product->title;
                  echo html::image($product->image->primary->smallURL, "title='{$title}' class='media-object'");
              }
              ?>
              <?php echo $product->summary;?>
            </p>
            <p><span class='muted'><?php echo date('Y/m/d', strtotime($product->addedDate));?></span></p>
          </div>
        </li>
      <?php endforeach;?>
      </ul>
      <div class='w-p95 pd-10px clearfix'><?php $pager->show('right', 'short');?></div>
      <div class='c-both'></div>
    </div>
  </div>
  <?php include '../../common/view/side.html.php';?>
</div>
<?php include '../../common/view/footer.html.php';?>
