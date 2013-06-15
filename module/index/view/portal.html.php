<div class='row'>
  <div class='u-24-19'>
    <div class='row'>
      <?php $hasLeftBlock = isset($layouts['left']);?>
      <?php if($hasLeftBlock):?>
      <div class='u-4-1'><div class='cont'><?php $this->block->printBlock($layouts, 'left');?></div></div>
      <div class='u-4-3'>
      <?php else:?>
      <div class='u-1'>
      <?php endif;?>
        <div class='cont bd-none'>
          <?php $this->block->printBlock($layouts, 'header');?>
          <?php foreach($articles as $moduleID => $moduleArticleses):?>
          <table class='table-1'>
            <caption>
              <div class='f-left'><?php echo $modules[$moduleID];?></div>
              <div class='f-right'><?php echo html::a($this->createLink('article', 'browse', "moduleID=$moduleID"), '更多');?>&nbsp;&nbsp;</div>
            </caption>
            <?php foreach($moduleArticleses as $article):?>
            <tr>
              <td><?php echo html::a($this->createLink('article', 'view', "articleID=$article->id"), $article->title);?></td>
              <td width='80'><?php echo substr($article->addedDate, 2, 8)?></td>
            </tr>
            <?php endforeach;?>
          </table>
          <?php endforeach;?>
        </div>
      </div>
    </div>
  </div>
  <div class='u-24-5'><div class='cont pl-10px'><?php include '../../common/view/blockright.html.php';?></div></div>
</div>
