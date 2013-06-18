<?php
$webRoot      = $this->app->getWebRoot();
$jsRoot       = $webRoot . "js/";
$themeRoot    = $webRoot . "theme/";
$defaultTheme = $webRoot . 'theme/default/';
$siteTheme    = $themeRoot . $this->app->site->theme . '/';
?>
<!DOCTYPE html>
<html lang='en'>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <?php
  $header = isset($header) ? (object)$header : new stdclass();
  if(!isset($header->title))    $header->title    = $lang->xirangEPS;
  if(!isset($header->keywords)) $header->keywords = $app->site->keywords;
  if(!isset($header->desc))     $header->desc     = $app->site->mission;
  echo html::title($header->title . '-' . $app->site->name);
  echo html::meta('keywords',    $header->keywords);
  echo html::meta('description', $header->desc);

  css::import($siteTheme . 'bootstrap.min.css', $config->version);

  js::exportConfigVars();
  if($config->debug)
  {
      css::import($siteTheme . 'style.css', $config->version);

      js::import($jsRoot . 'jquery/lib.js', $config->version);
      js::import($jsRoot . 'my.js', $config->version);
  }
  else
  {
      css::import($siteTheme . 'all.css', $config->version);
      js::import($jsRoot . 'all.js', $config->version);
  }

  if(isset($pageCss)) css::internal($pageCss);
  if(RUN_MODE == 'front')
  {
      if(strpos($siteTheme, 'default') === false) css::import($siteTheme . 'style.css', $config->version);
      css::import($themeRoot . "site/{$app->site->code}.css", $config->version);
      css::import($themeRoot . "lang/{$app->site->code}.{$this->cookie->lang}.css", $config->version);
  }
  else
  {
      css::import($themeRoot . 'default/admin.css', $config->version);
  }

  css::import($siteTheme . 'bootstrap-responsive.min.css', $config->version);

  echo html::icon($webRoot . 'favicon.ico');
  echo html::rss($config->webRoot .'rss.xml', $app->site->name);
?>
<script type="text/javascript">loadFixedCSS();</script>
</head>
<body>
