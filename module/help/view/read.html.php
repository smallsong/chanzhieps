<?php if(!empty($_GET['extra'])) die(include 'frameread.html.php');?>
<?php include '../../common/view/header.html.php'; ?>
<?php include '../../common/view/treeview.html.php'; ?>
<?php $common->printPositionBar($module, $article);?>
<div class='row'>
  <div class='u-1'>
    <div class='cont' id='doccontent'>
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
      <div class='row f-12px mt-10px'>
        <div class='u-3-1 a-left'> <?php $prev ? print($lang->article->prev . html::a(inlink('read', "id=$prev[id]"), $prev['title'])) : print($lang->article->none);?></div>
        <div class='u-3-1 a-center'><?php echo html::a(inlink('book', "book={$module['book']->id}&moduleID={$module['module']->id}"), $lang->article->menu);?></div>
        <div class='u-3-1 a-right'><?php $next ? print(html::a(inlink('read', "id=$next[id]"), $next['title']). $lang->article->next) : print($lang->article->none);?></div>
      </div>
    </div>
    <?php echo $this->fetch('comment', 'show', "object=article&id=$article->id");?>
  </div>
</div>
<?php include '../../common/view/syntaxhighlighter.html.php'; ?>
<?php include '../../common/view/footer.html.php'; ?>
