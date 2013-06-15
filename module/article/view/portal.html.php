<div class='row'>
  <div class='u-24-19'>
    <div class='cont bd-none'>
      <?php $this->block->printBlock($layouts, 'header');?>
      <table class='table-1 bd-none'>
        <caption><?php echo $module->name;?></caption>
        <?php foreach($articles as $article):?>
        <tr>
          <td>
            <?php 
            if('rssarticle' == $module->tree){ echo html::a($article->link, $article->title, '_blank', "class＝'colorbox'"); }
            else { echo html::a(inlink('view', "id=$article->id"), $article->title); }
            ?>
          </td>
          <td width='50'><?php echo substr($article->addedDate, 2, 8);?></td>
        </tr>
        <?php endforeach;?>
        <tr><td colspan='2'><?php $pager->show();?></td></tr>
      </table>
    </div>
  </div>
  <div class='u-24-5'><div class='cont pl-10px'><?php include '../../common/view/blockright.html.php';?></div></div>
</div>
