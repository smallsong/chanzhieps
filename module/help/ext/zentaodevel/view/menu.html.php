<?php include '../../../../common/view/bootstrapheader.lite.html.php';?>
<?php echo $book->name;?>
<div>
  <dl>
  <?php
  foreach($modules as $module)
  {
      if(isset($module->id))echo "<dt class='f-16px'><strong>$module->i.$module->name</strong></dt>";
      else $module->id=null;
      if(isset($articles[$module->id]) or isset($module->childs))
      {
          $j = 1;
          echo "<dd><dl>";
          if(isset($articles[$module->id]))
          {
              foreach($articles[$module->id] as $article)
              {
                  echo "<dt class='f-14px'>$module->i.$j " . html::a(inlink('read', "article=$article->id"), $article->title, 'content') . "</dt>";
                  $j ++;
              }
          }

          if(isset($module->childs))
          {
              foreach($module->childs as $child)
              {
                  echo "<dt class='f-14px'>$module->i.$child->j.$child->name</dt>";
                  if(isset($articles[$child->id]))
                  {
                      $k = 1;
                      echo "<dd><dl>";
                      foreach($articles[$child->id] as $article)
                      {
                          echo "<dt class='f-14px'>$module->i.$child->j.$k " . html::a(inlink('read', "article=$article->id", 'content'), $article->title) . "</dt>";
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
<?php include '../../../../common/view/bootstrapfooter.lite.html.php';?>
