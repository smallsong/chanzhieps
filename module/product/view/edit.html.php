<?php
/**
 * The create view file of product category of xirangEPS.
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
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/chosen.html.php';?>
<form method='post' class='form-inline' id='ajaxForm'> 
  <table class='table  table-hover table-form'>
    <caption><?php echo $lang->product->edit;?></caption>
    <tr>
      <th class='w-100px'><?php echo $lang->product->category;?></th>
      <td><?php echo html::select("categories[]", $categories, array_keys($product->categories), "multiple='multiple' class='select-3 chosen'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->name;?></th>
      <td><?php echo html::input('name', $product->name, "class='text-1'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->summary;?></th>
      <td><?php echo html::textarea('summary', $product->summary, "rows='2' class='area-1'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->content;?></th>
      <td valign='middle'><?php echo html::textarea('content', $product->content, "rows='10' class='area-1'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->keywords;?></th>
      <td><?php echo html::input('keywords', $product->keywords, "class='text-1'");?></td>
    </tr>
    <tr>
      <th rowspan='4'><?php echo $lang->product->attribute?></th>
      <td >
        <div class='col-lg-4'>
          <?php echo $lang->product->brand;?>
          <?php echo html::input('brand', $product->brand, "class='text-3'");?>
        </div>
        <div class='col-lg-4'>
          <?php echo $lang->product->model;?>
          <?php echo html::input('model', $product->model, "class='text-3'");?>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class='col-lg-4'>
          <?php echo $lang->product->color;?>
          <?php echo html::input('color', $product->color, "class='text-3'");?>
        </div>
        <div class='col-lg-4'>
          <?php echo $lang->product->amount;?> 
          <?php echo html::input('amount', $product->amount, "class='text-3'");?>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class='col-lg-4'>
          <?php echo $lang->product->origin;?>
          <?php echo html::input('origin', $product->origin, "class='text-3'");?>
        </div>
        <div class='col-lg-4'>
          <?php echo $lang->product->unit;?>
          <?php echo html::input('unit', $product->unit, "class='text-3'");?>
        </div>
      </td>
    </tr>
    <tr>
      <td>
        <div class='col-lg-4'>
          <?php echo $lang->product->price;?>
          <?php echo html::input('price', $product->price, "class='text-3'");?>
        </div>
        <div class='col-lg-4'>
<?php echo $lang->product->promotion;?>
        <?php echo html::input('promotion', $product->promotion, "class='text-3'");?>
        </div>
      </td>
    </tr>
    <tr>
      <td></td>
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
