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
      <ul>
      <?php foreach($articles as $article):?>
        <li>
          <?php 
          if(empty($article->images))
          {
              echo html::a(inlink('view', "id=$article->id"), html::image($themeRoot . 'default/images/main/noimage.jpg', "title='{$article->title}'"), '', "class='f-left article-img'");
          }
          else
          {
              $firstImage = $article->images[0];
              $title      = $firstImage->title ? $firstImage->title : $article->title;
              echo html::a(inlink('view', "id=$article->id"), html::image($firstImage->smallURL, "title='{$title}'"), '', "class='f-left article-img'");
          }
          ?>
          <div class='f-right w-p75'>
            <h5 class='article-title f-left'><?php echo html::a(inlink('view', "id=$article->id"), $article->title);?></h5>
            <span class='f-left'><?php echo date('Y/m/d', strtotime($article->addedDate));?></span>
            <div class='c-both'></div>
            <div class='pv-10px'><?php echo $article->summary;?></div>
          </div>
          <div class='c-both'></div>
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
