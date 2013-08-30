<?php include '../../../../common/view/bootstrapheader.lite.html.php'; ?>
<div>
  <h1 class='a-center'><?php echo $article->title;?></h1>
  <div class='a-center mb-10px'>
    <div class='f-12px'>
    <?php
    printf($lang->article->lblAddedDate, $article->addedDate);
    printf($lang->article->lblAuthor,    $article->author);
    printf($lang->article->lblViews,     $article->views);
    ?>
    </div>
    <?php $this->block->printBlock($layouts, 'header', false);?>
  </div>
  <?php if($article->summary) echo "<div id='summary'><strong>{$lang->article->summary}</strong>$lang->arrow$article->summary</div>";?>
  <div><?php echo $article->content;;?></div>
  <div class='a-right'><?php if($article->editor) printf($lang->article->lblEditor, $article->editor, $article->editedDate);?></div>
  <?php if($article->keywords) echo "<div id='keywords'><strong>{$lang->article->keywords}</strong>$lang->arrow$article->keywords</div>";?>
  <?php extract($prevAndNext);?>
  <?php echo $this->fetch('comment', 'show', "object=article&id=$article->id");?>
</div>
<?php include '../../../../common/view/bootstrapfooter.lite.html.php'; ?>
