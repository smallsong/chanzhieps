<?php
$config->webRoot = $this->app->getWebRoot();
$clientTheme     = $this->app->getClientTheme();
$webRoot         = $this->config->webRoot;
$jsRoot          = $webRoot . "js/";
$defaultTheme    = $webRoot . 'theme/default/';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8' />
  <?php
  echo html::title($header->title);
  js::exportConfigVars();
  js::import($jsRoot . 'jquery/lib.js');
  js::import($jsRoot . 'bootstrap/bootstrap.min.js');

  css::import($defaultTheme . 'bootstrap.min.css');
  css::import($defaultTheme . 'style.css');

  if(isset($pageCSS)) css::internal($pageCSS);
  ?>
</head>
<body style="margin-top:50px;">
