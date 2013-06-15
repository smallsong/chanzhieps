<?php
/**
 * The browse view file of block module of XiRangBPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/colorbox.html.php';?>
<div class="row">
  <div class='u-1'>
  <?php if($tree != 'article'):?><form method='post' action='<?php echo inlink('updateOrder');?>' target='hiddenwin'><?php endif;?>
  <table align='center' class='table-1 fixed'>
    <caption>
      <div class='f-left'><?php if($module) echo $module->name; echo $lang->article->list?> </div>
      <div class='f-right'><?php echo html::a(inlink('create', "module=" . ($module ? $module->id : $tree)), $lang->article->add);?></div>
    </caption>
    <tr>
      <?php if($tree != 'article'):?><th class='w-id'><?php echo $lang->article->order;?></th><?php endif;?>
      <th class='w-50px'><?php echo $lang->article->id;?></th>
      <th><?php echo $lang->article->title;?></th>
      <th class='w-user'><?php echo $lang->article->author;?></th>
      <th class='w-200px'><?php echo $lang->article->addedDate;?></th>
      <th class='w-140px'><?php echo $lang->actions;?></th>
    </tr>
    <?php $order = 5;?>
    <?php foreach($articles as $article):?>
    <tr class='a-center'>
      <?php if($tree != 'article'):?><td><?php echo html::input("orders[$article->id]", $order, 'class=text-1');?></td><?php endif;?>
      <td><?php echo $article->id;?></td>
      <td class='a-left'><?php echo $article->title;?></td>
      <td><?php echo $article->author;?></td>
      <td><?php echo $article->addedDate;?></td>
      <td>
        <?php 
        echo html::a(inlink('edit',   "articleID=$article->id"), $lang->edit);
        echo html::a(inlink('delete', "articleID=$article->id"), $lang->delete, 'hiddenwin');
        echo html::a($this->createLink('file', 'browse', "objectType=article&objectID=$article->id"), $lang->article->files, '', "class='file'");

        $config->requestType = 'PATH_INFO';
        $module = $tree == 'article' ? 'article' : 'help';
        $method = $tree == 'article' ? 'view' : 'read';
        echo html::a('http://' . $session->site->domain . $this->createLink($module, $method, "articleID=$article->id"), $lang->preview, '_blank', "class='colorbox'");
        $config->requestType = 'GET';
        ?>
      </td>
    </tr>
    <?php $order +=5;?>
    <?php endforeach;?>
    <tr>
      <?php $colspan = $tree == 'article' ? 5 : 6;?>
        <td colspan='<?php echo $colspan;?>'>
        <?php if($tree != 'article'):?><div class='f-left'><?php echo html::submitButton();?></div><?php endif;?>
        <div class='f-right'><?php $pager->show();?></div>
      </td>
    </tr>
  </table>
  </form>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
