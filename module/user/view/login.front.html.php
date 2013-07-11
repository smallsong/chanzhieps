<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <div class='span12'>
  <form method="post" id='ajaxForm' class="radius shadow front">
    <h3>
        <?php echo $lang->user->login->welcome;?></h3>
    <div id='responser' class='text-center'></div>
    <?php echo html::input('account','',"class='input-block-level' placeholder='{$lang->user->inputAccountOrEmail}'");?>
    <?php echo html::password('password','',"class='input-block-level' placeholder='{$lang->user->inputPassword}'");?>
    <?php // echo html::checkbox('keepLogin', $lang->user->login->keepLogin);?>
    <?php echo html::submitButton($lang->user->login->common, 'btn btn-primary');?>
  </form>
  </div>
</div>  
<?php include '../../common/view/footer.html.php';?>
