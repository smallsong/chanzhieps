<?php
/**
 * The browse view file of product of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php 
include '../../common/view/header.html.php';

$path = array_keys($category->pathNames);
js::set('path',  json_encode($path));

include '../../common/view/treeview.html.php';
?>
<?php echo $common->printPositionBar($category);?>
<div class='row'>
  <div class='col-md-9'>
    <div class='widget radius'>
      <h4><?php echo $category->name;?></h4>
      <ul class="media-list">
      <?php foreach($products as $product):?>
        <li class='media f-left'>
          <?php 
          $title = $product->image->primary->title ? $product->image->primary->title : $product->title;
          if(empty($product->image)) 
          {
              echo html::a(inlink('view', "id=$product->id"), html::image($themeRoot . 'default/images/main/noimage.gif', "title='{$title}'"), '', "class='media-image'");
          }
          else
          {
              echo html::a(inlink('view', "id=$product->id"), html::image($product->image->primary->smallURL, "title='{$title}'"), '', "class='media-image'");
          }
          ?>
          <div class='media-body'>
            <h5 class='media-heading'><?php echo html::a(inlink('view', "id=$product->id"), $product->name);?></h5>
            <p>
              <del><?php echo $lang->RMB . $product->price;?></del>
              <em><?php echo $lang->RMB . $product->promotion;?></em>
            </p>
          </div>
        </li>
      <?php endforeach;?>
      <div class='c-both'></div>
      </ul>
      <div class='w-p95 pd-10px clearfix'><?php $pager->show('right', 'short');?></div>
      <div class='c-both'></div>
    </div>
  </div>
  <?php include '../../common/view/side.html.php';?>
</div>
<?php include '../../common/view/footer.html.php';?>
