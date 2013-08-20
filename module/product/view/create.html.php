<?php
/**
 * The create view file of product category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
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
    <caption><?php echo $lang->product->create;?></caption>
    <tr>
      <th class='w-100px'><?php echo $lang->product->category;?></th>
      <td><?php echo html::select("categories[]", $categories, $currentCategory, "multiple='multiple' class='select-3 chosen'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->name;?></th>
      <td><?php echo html::input('name', '', "class='text-1'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->brand;?></th>
      <td><?php echo html::input('brand', '', "class='text-3'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->model;?></th>
      <td><?php echo html::input('model', '', "class='text-3'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->color;?></th>
      <td><?php echo html::input('color', '', "class='text-3'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->amount;?></th>
      <td><?php echo html::input('amount', '', "class='text-3'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->origin;?></th>
      <td><?php echo html::input('origin', '', "class='text-3'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->unit;?></th>
      <td><?php echo html::input('unit', '', "class='text-3'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->price;?></th>
      <td><?php echo html::input('price', '', "class='text-3'");?></td>
    </tr>
     <tr>
      <th><?php echo $lang->product->promotion;?></th>
      <td><?php echo html::input('promotion', '', "class='text-3'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->keywords;?></th>
      <td><?php echo html::input('keywords', '', "class='text-1'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->summary;?></th>
      <td><?php echo html::textarea('summary', '', "rows='2' class='area-1'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->product->content;?></th>
      <td valign='middle'><?php echo html::textarea('content', '', "rows='10' class='area-1'");?></td>
    </tr>
    <tr>
      <td></td>
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
