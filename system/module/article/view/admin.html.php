<?php
/**
 * The admin view file of article of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php if(strpos($type, 'book') !== false):?><form id='ajaxForm' method='post' action='<?php echo inlink('updateOrder', "type=$type");?>' target='hiddenwin'><?php endif;?>
<table class='table table-bordered table-hover table-striped'>
  <caption><?php echo $lang->article->list;?></caption>
  <thead>
    <tr class='a-center'>
      <?php if(strpos($type,'book') !== false):?><th class='w-80px'><?php echo $lang->article->order;?></th><?php endif;?>
      <th class='w-60px'><?php echo $lang->article->id;?></th>
      <th><?php echo $lang->article->title;?></th>
      <th class='w-p20'><?php echo $lang->article->category;?></th>
      <th class='w-160px'><?php echo $lang->article->addedDate;?></th>
      <th class='w-60px'><?php echo $lang->article->views;?></th>
      <th class='w-150px'><?php echo $lang->actions;?></th>
    </tr>
  </thead>
  <tbody>
    <?php $maxOrder = 0; foreach($articles as $article):?>
    <tr class='a-center'>
      <?php if(strpos($type, 'book') !== false):?>
      <td>
      <?php 
          if($article->order > $maxOrder) $maxOrder = $article->order;
          echo html::input("orders[$article->id]", $article->order, "class='text-1 a-center'");?>
      </td>
      <?php endif;?>
      <td><?php echo $article->id;?></td>
      <td class='a-left'><?php echo $article->title;?></td>
      <td class='a-left'><?php foreach($article->categories as $category) echo $category->name . ' ';?></td>
      <td><?php echo $article->addedDate;?></td>
      <td><?php echo $article->views;?></td>
      <td>
        <?php
        echo html::a($this->createLink('article', 'edit', "articleID=$article->id&type=$article->type"), $lang->edit);
        echo html::a($this->article->createPreviewLink($article->id), $lang->preview, '_blank');
        echo html::a($this->createLink('file',    'browse', "objectType=article&objectID=$article->id"), $lang->article->files, '', "data-toggle='modal' data-width='1000'");
        echo html::a($this->createLink('article', 'delete', "articleID=$article->id"), $lang->delete, '', 'class="deleter"');
        ?>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
  <tfoot>
    <tr>
      <?php $colspan = strpos($type, 'book') !==false ? 7 : 6;?>
      <td colspan='<?php echo $colspan;?>'>
        <?php if(strpos($type, 'book') !== false):?><div class='f-left'><?php echo html::submitButton() . html::hidden('maxOrder', $maxOrder);;?></div><?php endif;?>
        <?php $pager->show();?>
      </td>
    </tr>
  </tfoot>
</table>
<?php if(strpos($type, 'book') !== false):?></form><?php endif;?>
<?php include '../../common/view/footer.admin.html.php';?>
