<?php include '../../common/view/header.html.php'; ?>
<?php $common->printPositionBar($category);?>
<div class='row'>
  <div class='col-md-3'>
    <div class='widget box radius'>
      <h4><?php echo $lang->help->books;?></h4>
      <ul class='media-list'>
        <?php foreach($books as $bookValue):?>
        <li class='media'>
          <?php echo html::a(inlink('book', "book=$bookValue->code"), $bookValue->name);?>
        </li>
        <?php endforeach;?>
      </ul>
    </div>
  </div>

  <div class='col-md-9'>
    <div class='box radius'>  
      <h4><?php echo $book;?></h4>
      <dl>
      <?php
      foreach($categories as $category)
      {
          if(isset($category->id))echo "<dt class='f-16px'><strong>$category->i." . html::a(inlink('book',"book=$book&categoryID=$category->id"),$category->name) . "</strong></dt>";
          else $category->id=null;
          if(isset($articles[$category->id]) or isset($category->children))
          {
              $j = 1;
              echo "<dd><dl>";
              if(isset($articles[$category->id]))
              {
                  foreach($articles[$category->id] as $article)
                  {
                      echo "<dt class='f-14px'>$category->i.$j " . html::a(inlink('read', "article=$article->id"), $article->title) . "</dt>";
                      $j ++;
                  }
              }

              if(isset($category->children))
              {
                  foreach($category->children as $child)
                  {
                      echo "<dt class='f-14px'>$category->i.$child->j" . html::a(inlink('book', "book=$book->id&categoryID=$child->id"), $child->name) . "</dt>";
                      if(isset($articles[$child->id]))
                      {
                          $k = 1;
                          echo "<dd><dl>";
                          foreach($articles[$child->id] as $article)
                          {
                              echo "<dt class='f-14px'>$category->i.$child->j.$k " . html::a(inlink('read', "article=$article->id"), $article->title) . "</dt>";
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
<?php include '../../common/view/footer.html.php'; ?>
