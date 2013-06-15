<?php include '../../../../common/view/header.html.php'; ?>
<div style='height:400px; overflow:auto'>
  <div class='cont' id='doccontent'>
    <h1 class='a-center'><?php echo $article->title;?></h1>
    <div class='a-center mb-10px'>
      <div class='f-12px'>
      <?php
      printf($lang->article->lblAddedDate, $article->addedDate);
      printf($lang->article->lblAuthor,    $article->author);
      printf($lang->article->lblSource);
      if($article->original)
      {
          echo "<strong class='red'>{$lang->article->original}</strong>";
      }
      else
      {
          $article->copyURL ? print(html::a($article->copyURL, $article->copySite, '_blank')) : print($article->copySite);
      }
      printf($lang->article->lblViews, $article->views);
      ?>
      </div>
      <?php $this->block->printBlock($layouts, 'header', false);?>
    </div>

    <div>
      <?php
      if($article->summary) echo "<div id='summary'><strong>{$lang->article->summary}</strong>$lang->arrow$article->summary</div>";
      if(isset($article->images))
      {
          echo "<div class='a-center mb-10px'>";
          foreach($article->images as $image) echo html::a($image->fullURL, html::image($image->middleURL), '_blank');
          echo "</div>";
      }
      echo $article->content;
      ?>
    </div>
    <?php if(isset($article->files) and $article->files) echo $this->fetch('file', 'buildList', array($article->files));?>
    <?php if($article->keywords) echo "<div id='keywords'><strong>{$lang->article->keywords}</strong>$lang->arrow$article->keywords</div>";?>
    <div class='a-right'><?php if($article->editor) printf($lang->article->lblEditor, $article->editor, $article->editedDate);?></div>
  </div>
  <?php echo $this->fetch('comment', 'show', "object=article&id=$article->id");?>
</div>
<?php include '../../../../common/view/footer.html.php'; ?>
