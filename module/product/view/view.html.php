<?php
/**
 * The view file of product category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php 
include '../../common/view/header.html.php'; 
include '../../common/view/treeview.html.php'; 

/* set categoryPath for topNav highlight. */
js::set('path',  json_encode($product->path));
js::set('productID', $product->id);
?>
<?php $common->printPositionBar($category, $product);?>
<div class='row'>
  <?php include '../../common/view/side.html.php'; ?>
  <div class='col-md-9'>
    <div class='widget radius'>
      
      <div class='content'>
      
        <div>
          <?php if(empty($product->images)):?>
          <div class='pro-picture'>
            <?php  echo html::a(inlink('view', "id=$product->id"), html::image($themeRoot . 'default/images/main/noimage.gif'), '', "class='main-picture'");?>
          </div>
          <?php else:?>
          <div class='pro-picture'>
            <?php $images = array_merge($product->images); $firstImage = $images[0];?>
            <?php echo html::a(inlink('view', "id=$product->id"), html::image($firstImage->smallURL, "title='{$firstImage->title}'"), '', "class='main-picture'");?>
            <ul class='image-list'>
              <?php foreach($images as $image):?>
              <li>
                <?php echo html::a(inlink('view', "id=$product->id"), html::image($image->smallURL, "title='{$image->title}'"), '', "class='little-picture'");?>
              </li>
              <?php endforeach;?>
              <div class='c-both'></div>
            </ul>
          </div>
          <?php endif;?>

          <div class='property'>
            <h3><?php echo $product->name;?></h3>
            <table class='w-p100'>
              <?php if($product->promotion):?>
              <tr><th class='w-p50'><?php echo $lang->product->price . $lang->colon;?></th> <td><del><?php echo $product->price;?></del></td></tr>
              <tr><th><?php echo $lang->product->promotion . $lang->colon;?></th> <td><em><?php echo $product->promotion;?></em></td></tr>
              <?php else:?>
              <tr><th><?php echo $lang->product->price . $lang->colon;?></th> <td><em><?php echo $product->price;?></em></td></tr>
              <?php endif;?>
              <tr><th><?php echo $lang->product->unit   . $lang->colon;?></th> <td><?php echo $product->unit;?></td></tr>
              <tr><th><?php echo $lang->product->amount . $lang->colon;?></th> <td><?php echo $product->amount;?></td></tr>
              <tr><th><?php echo $lang->product->model  . $lang->colon;?></th> <td><?php echo $product->model;?></td></tr>
              <tr><th><?php echo $lang->product->brand  . $lang->colon;?></th> <td><?php echo $product->brand;?></td></tr>
              <tr><th><?php echo $lang->product->color  . $lang->colon;?></th> <td><?php echo $product->color;?></td></tr>
              <tr><th><?php echo $lang->product->origin . $lang->colon;?></th> <td><?php echo $product->origin;?></td></tr>
            </table>
          </div>
        </div>
        <div class='c-both'></div>
        <div class=''>
        <?php echo $product->content;?>
        </div>
        <div class='f-left'><?php $this->loadModel('file')->printFiles($product->files);?></div>
        <div class='c-both'></div>
      </div>
    </div>
    <div id='commentBox'></div>
    <?php echo html::a('', '', '', "name='comment'");?>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>
