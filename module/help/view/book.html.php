<?php if(!empty($_GET['extra'])) die(include 'framebook.html.php');?>
<?php include '../../common/view/header.html.php'; ?>
<?php $common->printPositionBar($module);?>
<div class='row'>
  <div class='u-24-5'>
    <div class='box-title'><?php echo $lang->help->books;?></div>
    <div class='box-content'>
      <?php
      foreach($lang->tree->lists as $bookID => $bookName)
      {
          if(strpos($bookID, 'help') !== false)
          {
              echo html::a(inlink('book', "book=$bookID"), $bookName);
              echo "<br />";
          }
      }
      ?>
    </div>
    <?php if(isset($layouts['left'])) $this->block->printBlock($layouts['left']);?>
  </div>

  <div class='u-24-19'>
    <div class='cont pl-10px'>  
      <?php $this->block->printBlock($layouts, 'header');?>
      <div class='box-title'><?php echo $book->name;?></div>
      <div class='box-content'>
        <dl>
        <?php
        foreach($modules as $module)
        {
            if(isset($module->id))echo "<dt class='f-16px'><strong>$module->i." . html::a(inlink('book',"book=$book->id&moduleID=$module->id"),$module->name) . "</strong></dt>";
            else $module->id=null;
            if(isset($articles[$module->id]) or isset($module->childs))
            {
                $j = 1;
                echo "<dd><dl>";
                if(isset($articles[$module->id]))
                {
                    foreach($articles[$module->id] as $article)
                    {
                        echo "<dt class='f-14px'>$module->i.$j " . html::a(inlink('read', "article=$article->id"), $article->title) . "</dt>";
                        $j ++;
                    }
                }

                if(isset($module->childs))
                {
                    foreach($module->childs as $child)
                    {
                        echo "<dt class='f-14px'>$module->i.$child->j" . html::a(inlink('book', "book=$book->id&moduleID=$child->id"), $child->name) . "</dt>";
                        if(isset($articles[$child->id]))
                        {
                            $k = 1;
                            echo "<dd><dl>";
                            foreach($articles[$child->id] as $article)
                            {
                                echo "<dt class='f-14px'>$module->i.$child->j.$k " . html::a(inlink('read', "article=$article->id"), $article->title) . "</dt>";
                                $k ++;
                            }
                            echo "</dl></dd>";
                        }
                    }
                }
                echo "</dl></dd>";
            }
        }
        ?>
        </dl>
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>
