<?php
if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}
$webRoot   = $config->webRoot;
$jsRoot    = $webRoot . "js/";
$themeRoot = $webRoot . "theme/";
$navs = $this->tree->getChildren(0, 'blog');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
  if(!isset($title))    $title    = ''; 
  if(!empty($title))    $title   .= $lang->minus;
  if(!isset($keywords)) $keywords = $config->site->keywords;
  if(!isset($desc))     $desc     = $config->site->desc;

  echo html::title($title . $config->site->name);
  echo html::meta('keywords',    strip_tags($keywords));
  echo html::meta('description', strip_tags($desc));

  css::import($themeRoot . 'bootstrap/css/core.min.css');
  css::import($themeRoot . 'default/blog.css');

  js::exportConfigVars();
  if($config->debug)
  {
      js::import($jsRoot . 'jquery/min.js');
      js::import($jsRoot . 'bootstrap/min.js');
      js::import($jsRoot . 'xirang.js');
      js::import($jsRoot . 'my.js');
  }
  else
  {
      js::import($jsRoot . 'all.js',  $config->version);
  }

  if(isset($pageCSS)) css::internal($pageCSS);

  echo html::icon($webRoot . 'favicon.ico');
  echo html::rss($config->webRoot .'rss.xml', $config->site->name);
  js::set('lang', $lang->js);
?>
<!--[if lt IE 9]>
<?php
js::import($jsRoot . 'html5shiv/min.js');
js::import($jsRoot . 'respond/min.js');
?>
<![endif]-->
</head>
<body>
<div class='container'>
  <div class="header">
    <ul class="nav nav-pills pull-right">
      <li <?php if(empty($category)) echo "class='active'"?>>
        <?php echo html::a($this->createLink('article', 'browse', "id={$nav->id}&type=blog"), $lang->home)?>
      </li>
      <?php 
      foreach($navs as $nav)
      {
          $class= $nav->id == $category->id ? "class='active'" : "";
          echo "<li {$class}>" . html::a($this->createLink('article', 'browse', "id={$nav->id}"), $nav->name) . '</li>';
      }
      ?>
    </ul>
    <h3 class="text-muted"><?php echo $this->config->site->name?></h3>
  </div>
