<?php include '../../common/view/header.lite.html.php';?>
<div id="adminContainer" class="container">
  <form method="post" id='ajaxForm' class="login-form radius shadow">
    <div id='logo'><?php echo html::image("$themeRoot/default/images/main/logo.login.png");?></div>
    <div id='responser' class='text-center'></div>
    <?php echo html::input('account','',"class='input-block-level' placeholder='{$lang->user->inputAccountOrEmail}'");?>
    <?php echo html::password('password','',"class='input-block-level' placeholder='{$lang->user->inputPassword}'");?>
    <?php // echo html::checkbox('keepLogin', $lang->user->login->keepLogin);?>
    <?php echo html::submitButton($lang->user->login->common, 'btn btn-primary');?>
  </form>
</div>
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if($config->debug) js::import($jsRoot . 'jquery/form/xirang.js');
if(isset($pageJS)) js::execute($pageJS);
?>
</body>
</html>
