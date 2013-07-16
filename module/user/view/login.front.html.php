<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <div class='span9'>
  <form method="post" id='ajaxForm' class="radius">
    <h3>
        <?php echo $lang->user->login->welcome;?></h3>
    <div id='responser' class='text-center'></div>
    <label><?php echo html::input('account','',"class='text-3' placeholder='{$lang->user->inputAccountOrEmail}'");?></label>
    <label><?php echo html::password('password','',"class='text-3' placeholder='{$lang->user->inputPassword}'");?></label>
    <div>
      <?php // echo html::checkbox('keepLogin', $lang->user->login->keepLogin);?>
      <?php echo html::submitButton($lang->user->login->common, 'btn btn-primary');?>
      <?php echo html::a(inlink('register'), $lang->register, '', 'class="btn"' );?>
    </div>
  </form>
  </div>
  <?php include '../../common/view/side.html.php'?>
</div>  
<?php include '../../common/view/footer.html.php';?>
