<?php
/**
 * The browse view file of product of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.chanzhi.org
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
    <div class='box radius'>
      <h4 class='title'><?php echo $category->name;?></h4>
      <ul class="media-list">
      <?php foreach($products as $product):?>
      <li class='media f-left'>
        <?php 
        $title = $product->image->primary->title ? $product->image->primary->title : $product->name;
        if(empty($product->image)) 
        {
            echo html::a(inlink('view', "id=$product->id"), html::image($themeRoot . 'default/images/main/noimage.gif', "title='{$title}' class='adaptive'"), '', "class='media-image'");
        }
        else
        {
            echo html::a(inlink('view', "id=$product->id"), html::image($product->image->primary->smallURL, "title='{$title}' class='adaptive' alt='{$product->name}'"), '', "class='media-image'");
        }
        ?>
        <div class='media-body'>
          <h5 class='media-heading'><?php echo html::a(inlink('view', "id=$product->id"), $product->name);?></h5>
          <?php if($product->promotion != 0 && $product->price != 0):?>
          <p>
            <del><?php echo $lang->RMB . $product->price;?></del>
            <em><?php echo $lang->RMB . $product->promotion;?></em>
          </p>
          <?php elseif($product->promotion == 0 && $product->price != 0):?>
          <p><em><?php echo $lang->product->price . $lang->RMB . $product->price;?></em></p>
          <?php elseif($product->promotion != 0 && $product->price == 0):?>
          <p><em><?php echo $lang->product->promotion . $lang->RMB . $product->promotion;?></em></p>
          <?php endif;?>
        </div>
      </li>
      <?php endforeach;?>
      <div class='c-both'></div>
      </ul>
      <div class='w-p95 pd-10px clearfix'><?php $pager->show('right', 'short');?></div>
      <div class='c-both'></div>
    </div>
  </div>
  <?php include './side.html.php';?>
</div>
<?php include '../../common/view/footer.html.php';?>
