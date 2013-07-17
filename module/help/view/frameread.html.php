<?php include '../../common/view/header.lite.html.php'; ?>
<?php include '../../common/view/treeview.html.php'; ?>
<style>
html{background:#fff}
body{background:#fff;}
#hiddenwin{background:#fff;}
#docbox{width:950px;}
</style>
<?php $extra = $_GET['extra'];?>
<div class='row'>
  <div class='u-24-5'>
    <div class='cont pr-10px'>
      <div class='box-title'><?php echo $lang->help->articles;?></div>
      <div class='box-content'>
        <?php 
        foreach($links as $id => $title)    
        {
            echo $lang->arrow .  ' ' . html::a(inlink('read', "articleID=$id") . "?extra=$extra", $title);
            echo "<br />";
        }
        echo '<p><strong>' . html::a(inlink('book', "book=$book->id") . "?extra=$extra", $lang->help->back) . '</strong></p>';
        ?>
      </div>
      <div class='box-title'><?php echo $lang->help->books;?></div>
      <div class='box-content'>
        <?php 
        foreach($lang->tree->lists as $bookID => $bookName)    
        {
            if(strpos($bookID, 'help') !== false)
            {
                echo html::a(inlink('book', "book=$bookID") . "?extra=$extra", $bookName);
                echo "<br />";
            }
        }
        ?>
      </div>
      <?php $this->block->printBlock($layouts, 'left');?>
    </div>
  </div>

  <div class='u-24-19'>
    <div class='cont' id='doccontent'>
      <h1 class='a-center'><?php echo $article->title;?></h1>
      <div class='a-center mb-10px'>
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
        $this->block->printBlock($layouts, 'header', false);
        ?>
      </div>

      <div><?php echo $article->content;;?></div>
      <div class='a-right'><?php if($article->editor) printf($lang->article->lblEditor, $article->editor, $article->editedDate);?></div>
    </div>
    <?php echo $this->fetch('comment', 'show', "object=article&id=$article->id");?>
  </div>
</div>
  <div class='row'><div class='u-1'><iframe name='hiddenwin' id='hiddenwin' class='<?php $config->debug ? print('debugwin') : print('hidden');?>'></iframe></div></div>
</div>
</body>
</html>
