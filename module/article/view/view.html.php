<?php 
include '../../common/view/header.html.php'; 
include '../../common/view/treeview.html.php'; 
js::set('currentMenu', "#category" . $category->id);
js::set('articleID', $article->id);
?>
<div class='row'>
  <div class='span9'>
    <?php $common->printPositionBar($category, $article);?>
    <h2><?php echo $article->title;?></h2>
      <div class='f-12px'>
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
    <div>
    <?php echo $article->content;?>
    </div>
    <div id="commentBox"> 
    </div>
    <?php echo html::a('', '', '', 'name="comment"');?>
    <div class='a-right'><?php if($article->editor) printf($lang->article->lblEditor, $article->editor, $article->editedDate);?></div>
  </div>
<?php include '../../common/view/side.html.php'; ?>
</div>
<?php include '../../common/view/footer.html.php'; ?>
