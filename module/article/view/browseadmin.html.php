<?php
/**
 * The browse view file of block category of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
    <form method="get" action="">
      <select id="subjectSelect" name="sID">
        <option value="0">类目筛选</option>
        <option value="1" isleaf="0">News</option>
        <option value="2" isleaf="1">&nbsp;├Company news</option>
        <option value="3" isleaf="1">&nbsp;├Industry news</option> 
      </select>
      <input type="submit" class="btn" value="筛选">
    </form>
    <?php if($tree != 'article'):?>
    <form method='post' action='<?php echo inlink('updateOrder');?>' target='hiddenwin' id="ajaxForm">
    <?php endif;?>
      <table style="margin-top:15px;" class="table table-bordered table-form">
        <caption><?php echo $lang->article->list;?></caption>
        <thead>
          <tr>
            <th class="w-30px"><?php echo $lang->article->id;?></th>
            <th ><?php echo $lang->article->title;?></th>
            <th class="w-150px"><?php echo $lang->actions;?></th>
            <th><?php echo $lang->article->category;?></th>
            <th class="w-140px"><?php echo $lang->article->addedDate;?></th>
            <th class="w-60px"><?php echo $lang->article->views;?></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($articles as $article):?>
          <tr ng-repeat="item in items" ng-class="'warning'|iftrue:clipboard.srcpath==curpath&amp;&amp;clipboard.items[item.name]" class="ng-scope">
            <td><?php echo $article->id;?></td>
            <td><?php echo $article->title;?></td>
            <td>
            <?php
              echo html::a(inlink('edit',   "articleID=$article->id"), $lang->edit);
              echo html::a(inlink('delete', "articleID=$article->id"), $lang->delete, 'hiddenwin');
              echo html::a($this->createLink('file', 'browse', "objectType=article&objectID=$article->id"), $lang->article->files, '', "class='file'");

              $config->requestType = 'PATH_INFO';
              $category = $tree == 'article' ? 'article' : 'help';
              $method = $tree == 'article' ? 'view' : 'read';
              echo html::a($this->createLink($category, $method, "articleID=$article->id"), $lang->preview, '_blank');
              $config->requestType = 'GET';
             ?>
             </td>
             <td>文章分类</td>
             <td><?php echo $article->addedDate;?></td>
             <td><?php echo $article->views;?></td>
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
     <?php if($tree != 'article'):?></form><?php endif;?>
