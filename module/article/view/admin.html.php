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
<table class='table table-bordered table-hover table-striped'>
  <caption>
    <div class='f-left'><?php echo $lang->article->list;?></div>
    <div class='f-right'><?php echo html::a($this->inlink('create'), $lang->article->create);?></div>
  </caption>
  <thead>
    <tr class='a-center'>
      <th class='w-id'><?php echo $lang->article->id;?></th>
      <th><?php echo $lang->article->title;?></th>
      <th class='w-p20'><?php echo $lang->article->category;?></th>
      <th class='w-140px'><?php echo $lang->article->addedDate;?></th>
      <th class='w-60px'><?php echo $lang->article->views;?></th>
      <th class='w-150px'><?php echo $lang->actions;?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($articles as $article):?>
    <tr class='a-center'>
      <td><?php echo $article->id;?></td>
      <td class='a-left'><?php echo $article->title;?></td>
      <td class='a-left'><?php foreach($article->categories as $category) echo $category->name . ' ';?></td>
      <td><?php echo $article->addedDate;?></td>
      <td><?php echo $article->views;?></td>
      <td>
        <?php
        echo html::a($this->createLink('article', 'edit', "articleID=$article->id"), $lang->edit);
        echo html::a($this->article->createPreviewLink($article->id, $article->type), $lang->preview, '_blank');
        echo html::a($this->createLink('file',    'browse', "objectType=article&objectID=$article->id"), $lang->article->files, '', "data-toggle='modal' data-width='1000'");
        echo html::a($this->createLink('article', 'delete', "articleID=$article->id"), $lang->delete, '', 'class="deleter"');
        ?>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
  <tfoot><tr><td colspan='6'><?php $pager->show();?></td></tr></tfoot>
</table>
<?php include '../../common/view/footer.admin.html.php';?>
