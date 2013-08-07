<?php 
include '../../common/view/header.html.php';

$categoryPath = array_keys($category->pathNames);
js::set('categoryPath',  json_encode($categoryPath));

include '../../common/view/treeview.html.php';
include 'portal.html.php';
include '../../common/view/footer.html.php'; 
?>
<?php echo $common->printPositionBar($category);?>
<div class='row'>
  <div class='span9'>
    <div class='widget widget-category radius'>
      <h4><?php echo $category->name;?></h4>
      <ul class='article-list'>
      <?php foreach($articles as $article):?>
        <li>
          <h5 class='article-title'><?php echo html::a(inlink('view', "id=$article->id"), $article->title);?></h5>
          <div class='meta'>
            <span class='f-12px'><?php echo $lang->article->addedDate;?>:<?php echo substr($article->addedDate, 2, 8);?></span> &nbsp;&nbsp;
          </div>
          <div class='summary'>
            <?php echo $article->summary;?> 
          </div>
        </li>
      <?php endforeach;?>
      </ul>
      <?php $pager->show();?>
    </div>
  </div>
  <?php include '../../common/view/side.html.php';?>
</div>
<?php include '../../common/view/footer.html.php';?>
