<?php include '../../../../common/view/header.html.php'; ?>
<?php include '../../../../common/view/treeview.html.php'; ?>
<div class='row'>
  <div class='u-4-1'><div class='cont'><?php include '../../../../common/view/blockleft.html.php';?></div></div>
  <div class='u-4-3'>
    <div class='cont bd-none'>
      <?php $this->block->printBlock($layouts, 'header');?>
      <?php foreach($articles as $moduleID => $moduleArticles):?>
        <table class='table-1'>
          <caption>
            <div class='f-left'><?php echo $indexModules[$moduleID];?></div>
            <div class='f-right'><?php echo html::a($this->createLink('article', 'browse', "moduleID=$moduleID"), '更多');?>&nbsp;&nbsp;</div>
          </caption>
          <?php if(strpos($config->dehai->imageModules, ",$moduleID,") !== false):?>
            <tr class='a-center imglist'><td>
            <?php foreach($moduleArticles as $article):?>
            <?php 
            echo '<div class=' . cycle('half-left, half-right') . '>';
            echo html::image($article->files[0]->smallURL) . '<br />';
            echo html::a($this->createLink('article', 'view', "articleID=$article->id"), $article->title);
            echo '</div>';
            ?>
            <?php endforeach;?>
            </td></tr>
          <?php else:?>
            <?php foreach($moduleArticles as $article):?>
            <tr>
              <td><?php echo html::a($this->createLink('article', 'view', "articleID=$article->id"), $article->title);?></td>
              <td width='80'><?php echo substr($article->addedDate, 2, 8)?></td>
            </tr>
            <?php endforeach;?>
          <?php endif;?>
       </table>
       <?php endforeach;?>
    </div>
  </div>
</div>
<?php include '../../../../common/view/footer.html.php'; ?>
