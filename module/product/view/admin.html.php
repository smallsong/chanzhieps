<?php
/**
 * The admin view file of product of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<table class='table table-bordered table-hover table-striped'>
  <caption>
    <div class='f-left'><?php echo $lang->product->list;?></div>
    <div class='f-right'><?php echo html::a($this->inlink('create'), $lang->product->create);?></div>
  </caption>
  <thead>
    <tr class='a-center'>
      <th class='w-id'><?php echo $lang->product->id;?></th>
      <th><?php echo $lang->product->name;?></th>
      <th class='w-p20'><?php echo $lang->product->category;?></th>
      <th class='w-p20'><?php echo $lang->product->amount;?></th>
      <th class='w-140px'><?php echo $lang->product->addedDate;?></th>
      <th class='w-60px'><?php echo $lang->product->views;?></th>
      <th class='w-150px'><?php echo $lang->actions;?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($products as $product):?>
    <tr class='a-center'>
      <td><?php echo $product->id;?></td>
      <td class='a-left'><?php echo $product->name;?></td>
      <td class='a-left'><?php foreach($product->categories as $category) echo $category->name . ' ';?></td>
      <td><?php echo $product->amount;?></td>
      <td><?php echo $product->addedDate;?></td>
      <td><?php echo $product->views;?></td>
      <td>
        <?php
        echo html::a($this->createLink('product', 'edit', "productID=$product->id"), $lang->edit);
        echo html::a(commonModel::createFrontLink('product', 'view',  "productID=$product->id", $product->type), $lang->preview, '_blank');
        echo html::a($this->createLink('file',    'browse', "objectType=product&objectID=$product->id"), $lang->product->files, '', "data-toggle='modal' data-width='1000'");
        echo html::a($this->createLink('product', 'delete', "productID=$product->id"), $lang->delete, '', 'class="deleter"');
        ?>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
  <tfoot><tr><td colspan='7'><?php $pager->show();?></td></tr></tfoot>
</table>
<?php include '../../common/view/footer.admin.html.php';?>
