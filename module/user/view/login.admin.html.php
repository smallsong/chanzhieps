<?php
$config->webRoot = $this->app->getWebRoot();
$clientTheme     = $this->app->getClientTheme();
$webRoot         = $this->config->webRoot;
$jsRoot          = $webRoot . "js/";
$defaultTheme    = $webRoot . 'theme/default/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset='utf-8' />
  <?php
  echo html::title($header->title);
  js::exportConfigVars();
  js::import($jsRoot . 'jquery.js');
  js::import($jsRoot . 'bootstrap/bootstrap.min.js');
  js::import($jsRoot . 'xirang.js');
  js::set('lang', $lang->js);

  css::import($defaultTheme . 'bootstrap.min.css');
  ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keyword" content="">
  <meta name="description" content="">
  <style type="text/css">
  body {padding-top: 60px;padding-bottom: 40px;background-color: #f6f5f5;}
  .logo{display:block;margin:0 auto;text-align:center;}
  .logo img{width:150px;padding:0 0 10px 0;}
  .navbar-container{width:1170px;margin:0 auto;}
  .container{margin-top:30px;}
  .form-signin {max-width: 300px;padding: 19px 29px 29px;margin: 0 auto 20px;background-color: #fff;border: 1px solid #e5e5e5;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);box-shadow: 0 1px 2px rgba(0,0,0,.05);}
  .form-signin .form-signin-heading, .form-signin .checkbox {margin-bottom: 10px;}
  .form-signin input[type="text"],.form-signin input[type="password"] {font-size: 16px;height: auto;margin-bottom: 15px;padding: 7px 9px;}
  .validateForm label.error{ font-size:12px; color:#B94A48;}
  </style>
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script src="<?php echo $jsRoot . 'js/html5shiv.js'; ?>"></script>
  <![endif]-->
  <!-- Fav and touch icons -->
  <link rel="shortcut icon" href="../assets/ico/favicon.png">
</head>
<body>
  <div class="container">
    <form action="<?php echo $this->createLink('user', 'login');?>" method="post" class="form-signin">
      <a class="logo"><img src="<?php echo $defaultTheme . 'images/default/login_logo.png'; ?>" /></a>
        <?php echo html::input('account', '', "class=\" required  input-block-level\" placeholder=\"{$lang->user->inputUserName}\""); ?>
        <?php echo html::password('password', '', "class=\"required input-block-level\" placeholder=\"{$lang->user->inputPassword}\""); ?>
        <label class="checkbox" for="remember-me">
        <input type="checkbox" id="remember-me" value="remember-me">
        <?php echo $lang->user->login->keep;?>
        </label>
        <?php echo html::submitButton($lang->user->login->common, 'class="btn-large"');?>
    </form>
  </div>
</body>
</html>
