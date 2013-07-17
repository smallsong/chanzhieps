<?php include '../../common/view/header.html.php';?>
<?php if($result):?>
  <h1 class='f-16px strong a-center green'><?php echo $lang->donation->thanks;?></h1>
<?php else:?>
  <h1 class='f-16px strong a-center red'><?php echo $lang->donation->payFail;?></h1>
<?php endif;?>
<div class='a-center f-14px strong'>
  <?php echo html::a($this->createLink('help', 'donation'), $lang->donation->view)?>
</div>
<?php include '../../common/view/footer.html.php';?>
