<?php
/**
 * The browse view file of article of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<table class="table table-hover table-bordered table-striped">
  <caption><?php echo $lang->article->list;?></caption>
  <thead>
    <tr>
      <th class="w-30px"><?php echo $lang->article->id;?></th>
      <th class="w-p30"><?php echo $lang->article->title;?></th>
      <th class="w-p20"><?php echo $lang->article->category;?></th>
      <th class="w-140px"><?php echo $lang->article->addedDate;?></th>
      <th class="w-60px"><?php echo $lang->article->views;?></th>
      <th class="w-150px"><?php echo $lang->actions;?></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($articles as $article):?>
    <tr>
      <td><?php echo $article->id;?></td>
      <td><?php echo $article->title;?></td>
      <td>
        <?php
        $sp = "";
        foreach($article->categories as $category)
        {
            echo $sp . $categories[$category->category];
            $sp = "&nbsp;";
        }
        ?>
      </td>
      <td><?php echo $article->addedDate;?></td>
      <td><?php echo $article->views;?></td>
      <td>
        <?php
        echo html::a(inlink('edit',   "articleID=$article->id"), $lang->edit);
        echo html::a(inlink('delete', "articleID=$article->id"), $lang->delete, '', 'class="delete"');
        echo html::a($this->createLink('file', 'browse', "objectType=article&objectID=$article->id"), $lang->article->files, '', "data-toggle='modal' w='1000'");

        $category = $tree == 'article' ? 'article' : 'help';
        $method = $tree == 'article' ? 'view' : 'read';
        echo html::a($this->createLink($category, $method, "articleID=$article->id"), $lang->preview, '_blank');
        ?>
       </td>
     </tr>
   <?php endforeach;?>
     <tr>
       <?php $colspan = $tree == 'article' ? 7 : 8;?>
       <td colspan='<?php echo $colspan;?>'>
       <?php if($tree != 'article'):?><div class='f-left'><?php echo html::submitButton();?></div><?php endif;?>
       <div class='f-right'><?php $pager->show();?></div>
       </td>
     </tr>
   </tbody>
 </table>
 <?php include '../../common/view/footer.admin.html.php';?>
