<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <div class='u-1'>
    <table class='table-1'>
	  <caption><?php echo $lang->donation->confirm;?></caption>
      <tr> 
        <th><?php echo $lang->donation->id;?></th>
        <th><?php echo $lang->donation->subject;?></th>
        <th width='80'><?php echo $lang->donation->price;?></th>
      </tr>
      <tr class='a-center'> 
        <td><?php echo $order->humanOrder;?></td>
        <td><?php echo $order->subject;?></td>
        <td><?php echo $order->money . $lang->rmb;?></td>
      </tr>
    </table>
    <p class='a-center'><?php echo html::a($payLink, html::image($themeRoot . 'site/images/5upm/alipay.gif'));?></p>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
