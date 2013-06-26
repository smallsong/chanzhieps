<?php include '../../common/view/header.lite.html.php';?>
<div class="container">
  <form method="post" id='ajaxForm' class="radius-5px">
    <div id='logo'><?php echo html::image("$themeRoot/default/images/main/logo.login.png");?></div>
    <?php echo html::input('account','','class="input-block-level"');?>
    <?php echo html::password('password','','class="input-block-level"');?>
    <?php echo html::checkbox('keepLogin', $lang->user->login->keepLogin);?>
    <?php echo html::submitButton($lang->user->login->common, 'btn btn-primary');?>
    <span id='responser'></span>
  </form>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
