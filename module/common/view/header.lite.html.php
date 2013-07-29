<?php
$webRoot   = $this->app->getWebRoot();
$jsRoot    = $webRoot . "js/";
$themeRoot = $webRoot . "theme/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <?php
  if(!isset($title))    $title    = $lang->xirangEPS;
  if(!isset($keywords)) $keywords = $config->site->keywords;
  if(!isset($desc))     $desc     = $config->site->desc;

  echo html::title($title . '-' . $config->site->name);
  echo html::meta('keywords',    $keywords);
  echo html::meta('description', $desc);

  js::exportConfigVars();
  if($config->debug)
  {
      js::import($jsRoot . 'jquery/min.js');
      js::import($jsRoot . 'bootstrap/min.js');
      js::import($jsRoot . 'my.js');
      // css::import($themeRoot . 'bootstrap/css/core.min.css');
      css::import($themeRoot . 'default/bootstrap.zentao.min.css');
      css::import($themeRoot . 'default/font-awesome.css');
      css::import($themeRoot . 'default/style.css');
  }
  else
  {
      css::import($themeRoot . 'default/all.css', $config->version);
      js::import($jsRoot     . 'all.js',  $config->version);
  }

  if(isset($pageCSS)) css::internal($pageCSS);
  if(RUN_MODE == 'admin') css::import($themeRoot . 'default/admin.css', $config->version);
  if(RUN_MODE == 'front') css::import($themeRoot . 'default/front.css', $config->version);

  echo html::icon($webRoot . 'favicon.ico');
  echo html::rss($config->webRoot .'rss.xml', $config->site->name);
?>
</head>

<?php
  if(RUN_MODE == 'admin'){
    echo '<body class="with-navbar-fixed-both">';
  }
  else{
    echo '<body>';
  }
?>