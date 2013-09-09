<?php
/**
 * The index view file of blog module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php 
include './header.html.php';
$path = array_keys($category->pathNames);
js::set('path',  json_encode($path));
include '../../common/view/treeview.html.php';
?>
<?php
$root = '<li>' .  html::a($this->inlink('index'), $lang->home) . '</li>';
if(!empty($category)) echo $common->printPositionBar($category, '', '', $root);
?>
<div class='row blogBox'>
  <div class='col-md-9'>
    <ul class="media-list">
    <?php foreach($articles as $article):?>
      <li class="media radius">
        <p class="pull-left"><strong class='dater'><?php echo date('Y/m/d', strtotime($article->addedDate));?></strong></p>
        <div class='media-body'>
          <h3 class='media-heading'><?php echo html::a(inlink('view', "id=$article->id"), $article->title);?></h3>
          <p>
            <?php 
            if(!empty($article->image))
            {
                $title = $article->image->primary->title ? $article->image->primary->title : $article->title;
                echo html::image($article->image->primary->smallURL, "title='{$title}' class='media-object'");
            }
            ?>
            <?php echo $article->summary;?>
          </p>
        </div>
      </li>
    <?php endforeach;?>
    </ul>
    <div class='w-p95 pd-10px clearfix'><?php $pager->show('right', 'short');?></div>
    <div class='c-both'></div>
  </div>
  <?php include './side.html.php';?>
</div>
<?php include './footer.html.php';?>
