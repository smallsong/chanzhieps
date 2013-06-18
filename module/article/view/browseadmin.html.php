<?php
/**
 * The browse view file of block module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/colorbox.html.php';?>
<div class="container">
  <h3><?php echo $session->site->name . $lang->colon . $lang->admin->manageArticle?></h3>
  <div class="tabbable">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab1" data-toggle="tab"><?php if($module) echo $module->name; echo $lang->article->list?></a></li>
      <li><a href="#tab2" data-toggle="tab">类目管理</a></li>
      <li><a href="#tab3" data-toggle="tab"><?php echo $lang->article->add;?></a></li>
    </ul>
    <div class="tab-content">
    <div class="tab-pane active" id="tab1">
    <form method="get" action="">
      <select id="subjectSelect" name="sID">
        <option value="0">分类筛选</option>
        <option value="1" isleaf="0">News</option>
        <option value="2" isleaf="1">&nbsp;├Company news</option>
        <option value="3" isleaf="1">&nbsp;├Industry news</option> 
      </select>
      <select name="topType">
        <option value="">推荐筛选</option>
        <option value="onIndex">首页推荐</option>
        <option value="onCate">类目推荐</option>
      </select>
      <select id="stateID" name="stateID">
        <option selected="selected" value="">状态筛选</option>
        <option value="1">发布中</option>
        <option value="3">草稿</option> 
        <option value="2">回收站</option>
      </select>
      <input type="submit" class="btn" value="筛选">
    </form>
    <?php if($tree != 'article'):?><form method='post' action='<?php echo inlink('updateOrder');?>' target='hiddenwin'><?php endif;?>
    <table style="margin-top:15px;" class="table table-hover">
    <thead>
    <tr>
    <th style="width:10px"><input type="checkbox" ng-model="selectall" class="ng-pristine ng-valid"></th>
    <th><?php echo $lang->article->id;?></th>
    <th><?php echo $lang->article->title;?></th>
    <th style="width:140px"><?php echo $lang->actions;?></th>
    <th style="width:140px">文章分类</th>
    <th style="width:140px"><?php echo $lang->article->addedDate;?></th>
    <th style="width:140px">浏览次数</th>
    </tr>
    </thead>
    <tbody>
    <tr ng-show="items.length==0" style="display: none;">
    <td colspan="10">当前目录是空的。</td>
    </tr>
    <?php foreach($articles as $article):?>
    <tr ng-repeat="item in items" ng-class="'warning'|iftrue:clipboard.srcpath==curpath&amp;&amp;clipboard.items[item.name]" class="ng-scope">
      <td><input type="checkbox" ng-model="selects[item.name]" class="ng-pristine ng-valid"></td>
      <td><?php echo $article->id;?></td>
      <td><?php echo $article->title;?></td>
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
    </div>
    <div class="tab-pane" id="tab2">
    <p>hahaha</p>
    </div>
    <div class="tab-pane" id="tab3">
      <?php include 'create.html.php';?>
    </div>
    </div>
  </div>
</div>
