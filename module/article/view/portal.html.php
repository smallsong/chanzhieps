<div class='row'>
  <div class='span9'>
    <?php $this->block->printBlock($layouts, 'header');?>
    <h2><?php echo $category->name;?></h2>
    <ul class='article-list'>
    <?php foreach($articles as $article):?>
      <li>
        <h3 class='article-title'><?php echo html::a(inlink('view', "id=$article->id"), $article->title);?></h3>
        <span><?php echo substr($article->addedDate, 2, 8);?>
      </li>
    <?php endforeach;?>
    </ul>
    <?php $pager->show();?>
  </div>
  <div class='span3'><?php include '../../common/view/side.html.php';?></div>
</div>
