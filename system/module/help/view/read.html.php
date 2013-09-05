<?php
include '../../common/view/header.html.php';
include '../../common/view/treeview.html.php';

js::set('articleID', $article->id);
?>
<?php $common->printPositionBar($category, $article);?>
<div class='box radius'>
  <div class='content'>
    <h1 class='a-center'><?php echo $article->title;?></h1>
    <div class='a-center mb-10px'>
      <div class='f-12px'>
      <?php
      printf($lang->article->lblAddedDate, $article->addedDate);
      printf($lang->article->lblAuthor,    $article->author);
      printf($lang->article->lblViews,     $article->views);
      ?>
      </div>
    </div>
    <div><?php echo $article->content;;?></div>
    <?php if($article->keywords) echo "<div id='keywords'><strong>{$lang->article->keywords}</strong>$lang->colon$article->keywords</div>";?>
    <?php extract($prevAndNext);?>
    <div class='row f-12px mt-10px'>
      <div class='col-md-4 a-left'> <?php $prev ? print($lang->article->prev . html::a(inlink('read', "id=$prev[id]"), $prev['title'])) : print($lang->article->none);?></div>
      <div class='col-md-4 a-center'><?php echo html::a(inlink('book', "type=$type&category={$category->id}"), $lang->article->directory);?></div>
      <div class='col-md-4 a-right'><?php $next ? print(html::a(inlink('read', "id=$next[id]"), $next['title']). $lang->article->next) : print($lang->article->none);?></div>
    </div>
  </div>
</div>
<div id='commentBox'></div>
<?php echo html::a('', '', '', "name='comment'");?>
<?php include '../../common/view/syntaxhighlighter.html.php'; ?>
<?php include '../../common/view/footer.html.php'; ?>
