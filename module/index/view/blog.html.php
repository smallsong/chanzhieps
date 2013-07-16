<div class='row'>
  <div class='u-24-19'>
    <div class='row'>
      <div class='u-1'>
        <div class='cont'>
          <?php $this->block->printBlock($layouts, 'header');?>
          <?php foreach($articles as $article):?>
          <div class='article'>
            <div class='box-title'><?php echo $article->title;?></div>
            <div class='box-content'><?php echo $article->digest; echo "<div class='mt-5px'></div>";?></div>
            <span class='box-articleFull'><?php echo html::a($this->createLink('article', 'view', "articleID=$article->id"), $lang->articleFull . $lang->arrow); ?></span>
            <?php
              printf($lang->articleViews, $article->views);
              printf($lang->articleComments, $comments[$article->id]) . '| ';
              printf($lang->articleAuthor, $article->author, $article->addedDate);
              if($article->module) echo html::a($this->createLink('article', 'browse', "moduleID=$article->module"), ' / ' . $modules[$article->module]);
            ?>
          </div>
          <?php endforeach;?>
          <?php $pager->show();?>
        </div>
      </div>
    </div>
  </div>
  <div class='u-24-5'><div class='cont pl-10px'><?php include '../../common/view/blockright.html.php';?></div></div>
</div>
