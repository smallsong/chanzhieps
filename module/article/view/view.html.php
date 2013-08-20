<?php 
include '../../common/view/header.html.php'; 
include '../../common/view/treeview.html.php'; 

/* set categoryPath for topNav highlight. */
js::set('path',  json_encode($article->path));

js::set('articleID', $article->id);
?>
<?php $common->printPositionBar($category, $article);?>
<div class='row'>
  <div class='col-md-9'>
    <div class='widget radius'>
      <div class='content'>
        <h2 class='a-center'><?php echo $article->title;?></h2>
        <div class='f-12px mb-10px a-center'>
          <?php
          printf($lang->article->lblAuthor,    $article->author);
          if($article->original)
          {
              echo "<strong>{$lang->article->originalList[$article->original]}</strong>";
          }
          else
          {
              printf($lang->article->lblSource);
              $article->copyURL ? print(html::a($article->copyURL, $article->copySite, '_blank')) : print($article->copySite); 
          }
          printf($lang->article->lblViews, $article->views);
          ?>
        </div>
        <p><?php echo $article->content;?></p>
        <div class='f-left'><?php $this->loadModel('file')->printFiles($article->files);?></div>
      </div>
    </div>
    <div id='commentBox'></div>
    <?php echo html::a('', '', '', "name='comment'");?>
  </div>
  <?php include '../../common/view/side.html.php'; ?>
</div>
<?php include '../../common/view/footer.html.php'; ?>
