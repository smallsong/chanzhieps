<?php include '../../common/view/header.lite.html.php';?>
<?php css::internal('body{background-color:#f6f5f5}');?> 
<form method="post" id='ajaxForm' class='radius shadow admin'>
  <div id='logo'><?php echo html::image("$themeRoot/default/images/main/logo.login.png");?></div>
  <div id='responser' class='text-center'></div>
  <?php echo html::input('account','',"class='input-block-level' placeholder='{$lang->user->inputAccountOrEmail}'");?>
  <?php echo html::password('password','',"class='input-block-level' placeholder='{$lang->user->inputPassword}'");?>
  <?php echo html::hidden('referer', $referer);?>
  <?php echo html::submitButton($lang->user->login->common, 'btn btn-primary');?>
</form>
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);
?>
</body>
</html>
