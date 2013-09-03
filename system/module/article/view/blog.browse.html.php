<?php 
include './blog.header.html.php';
$path = array_keys($category->pathNames);
js::set('path',  json_encode($path));
include '../../common/view/treeview.html.php';
?>
<?php
$root = '<li>' .  html::a($this->createLink('article', 'browse', "id=0&type=blog"), $lang->home) . '</li>';
if(!empty($category)) echo $common->printPositionBar($category, '', '', $root);
?>
<div class='row blogBox'>
  <div class='col-md-9'>
    <div class='box radius'>
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
              <?php echo $article->summary;?>
            </p>
            <p><span class='muted'><?php echo date('Y/m/d', strtotime($article->addedDate));?></span></p>
          </div>
        </li>
      <?php endforeach;?>
      </ul>
      <div class='w-p95 pd-10px clearfix'><?php $pager->show('right', 'short');?></div>
      <div class='c-both'></div>
    </div>
  </div>
  <?php include './blog.side.html.php';?>
</div>
<?php include '../../common/view/footer.html.php';?>
