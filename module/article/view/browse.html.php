<?php 
include '../../common/view/header.html.php';

$path = array_keys($category->pathNames);
js::set('path',  json_encode($path));

include '../../common/view/treeview.html.php';
?>
<?php echo $common->printPositionBar($category);?>
<div class='row'>
  <div class='span9'>
    <div class='widget radius'>
      <h4><?php echo $category->name;?></h4>
      <ul class="media-list">
      <?php foreach($articles as $article):?>
        <li class="media">
          <div class='media-body'>
            <h3 class='media-heading'><?php echo html::a(inlink('view', "id=$article->id"), $article->title);?></h3>
            <p>
              <?php 
              if(!empty($article->image))
              {
                  $title = $article->image->primary->title ? $article->image->primary->title : $article->title;
                  echo html::image($article->image->primary->smallURL, "title='{$title}' class='media-object'");
              }
              ?>
              <?php echo $article->summary;?></p>
            <p><span class='muted'><?php echo date('Y/m/d', strtotime($article->addedDate));?></span></p>
          </div>
        </li>
      <?php endforeach;?>
      </ul>
      <div class='w-p95 pd-10px'><?php $pager->show('right', 'short');?></div>
      <div class='c-both'></div>
    </div>
  </div>
  <?php include '../../common/view/side.html.php';?>
</div>
<?php include '../../common/view/footer.html.php';?>
