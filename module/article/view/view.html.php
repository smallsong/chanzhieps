<?php 
include '../../common/view/header.html.php'; 
include '../../common/view/treeview.html.php'; 

/* set categoryPath for topNav highlight. */
js::set('categoryPath',  json_encode($categoryPath));

js::set('articleID', $article->id);
?>
<?php $common->printPositionBar($category, $article);?>
<div class='row'>
  <div class='span9'>
    <div class='widget widget-category radius'>
      <h4><?php echo $article->title;?></h4>
      <div class='content'>
        <div class='f-12px mb-10px'>
          <?php
          printf($lang->article->lblAddedDate, $article->addedDate);
          printf($lang->article->lblAuthor,    $article->author);
          printf($lang->article->lblSource);
          if($article->original)
          {
              echo "<strong>{$lang->article->original}</strong> &nbsp;&nbsp;";
          }
          else
          {
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
                echo html::image($file->smallURL, "title='{$file->title}' class='w-p45'");
            }
            else
            {
                echo html::a(inlink('download', "id=$file->id"), "{$file->title}.{$file->extension}", '_blank');
            }
        }
        ?> 
      </div>
    </div>
    <div id='commentBox'></div>
    <?php echo html::a('', '', '', "name='comment'");?>
    <div class='a-right'><?php if($article->editor) printf($lang->article->lblEditor, $article->editor, $article->editedDate);?></div>
  </div>
<?php include '../../common/view/side.html.php'; ?>
</div>
<?php include '../../common/view/footer.html.php'; ?>
