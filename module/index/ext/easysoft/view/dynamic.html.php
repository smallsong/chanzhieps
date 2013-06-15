<div class='blockBox' id='dynamic'>
  <div class='block4x3' style='background:#eee;'>
    <div class='block4x1'>
      <div class='f-left'><h2>易软动态</h2></div>
      <div class='f-right'><?php echo html::a($this->createLink('article', 'browse', "module=8"), '更多', '_blank');?></div>
    </div>
    <?php foreach(array_slice($articles[$this->config->index->modules['dynamic']], 0, 4) as $article):?>
    <div>
      <h4><?php echo html::a($this->createLink('article', 'view', "id=$article->id"), $article->title) . substr($article->addedDate, 2, 8);?></h4>
      <p><?php echo $article->summary; ?></p>
    </div>
    <?php endforeach;?>
  </div>
</div>  
