<?php 
include '../../common/view/header.html.php'; 
include '../../common/view/treeview.html.php'; 

/* set categoryPath for topNav highlight. */
js::set('path',  json_encode($article->path));

js::set('articleID', $article->id);
?>
<?php $common->printPositionBar($category, $article);?>
<div class='row'>
  <div class='span9'>
    <div class='widget radius'>
      <div class='content'>
        <h3 class='a-center'><?php echo $article->title;?></h3>
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
        <div><?php echo $article->content;?></div>
        <?php
        foreach($article->files as $file)
        {
            if($file->isImage)
            { 
                echo html::image($file->smallURL, "title='{$file->title}'");
            }
            else
            {
                echo html::a($this->createLink('file', 'download', "id=$file->id"), "{$file->title}.{$file->extension}", '_blank') . '<br/>';
            }
        }
        ?> 
      </div>
      <div class='a-right mg-10px'><?php if($article->editor) printf($lang->article->lblEditor, $article->editor, $article->editedDate);?></div>
    </div>
    <div id='commentBox'></div>
    <?php echo html::a('', '', '', "name='comment'");?>
  </div>
  <?php include '../../common/view/side.html.php'; ?>
</div>
<?php include '../../common/view/footer.html.php'; ?>
