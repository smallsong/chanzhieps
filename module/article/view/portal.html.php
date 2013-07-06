<div class='row'>
  <div class='span9'>
    <?php echo $common->printPositionBar($category);?>
    <ul class='article-list'>
    <?php foreach($articles as $article):?>
      <li>
        <h3 class='article-title'><?php echo html::a(inlink('view', "id=$article->id"), $article->title);?></h3>
        <div class='meta a-right'>
          <span><strong><?php echo $lang->article->addedDate;?>:</strong><?php echo substr($article->addedDate, 2, 8);?></span> &nbsp;&nbsp;
        </div>
        <div class='summary'>
          <?php echo $article->summary;?> 
        </div>
          <?php echo html::a(inlink('view', "id=$article->id"), '更多>>', '', "class='readmore'");?>
      </li>
    <?php endforeach;?>
    </ul>
    <?php $pager->show();?>
  </div>
  <div class='span3'><?php include '../../common/view/side.html.php';?></div>
</div>
