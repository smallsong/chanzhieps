<?php
/**
 * The common header file of blog module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
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
      js::import($jsRoot . 'chanzhi.js');
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
    <div class="header-top">
      <div class="nav pull-right">
        <?php echo commonModel::printTopBar();?> | <?php echo html::a($config->webRoot, $lang->blog->siteHome);?>
      </div>
      <?php if(isset($config->site->logo)):?>
      <?php $logo = json_decode($config->site->logo);?>
      <h3>
        <?php echo html::a($this->config->webRoot, html::image($logo->webPath, "id='logo' title='{$this->config->company->name}'"));?>
      </h3>
      <?php else:?>
      <h3><?php echo $this->config->site->name?></h3>
      <?php endif;?>      
    </div>
    <ul class="nav nav-pills">
      <li <?php if(empty($category)) echo "class='active'"?>>
         <?php echo html::a($this->inlink('index'), $lang->blog->home)?>
      </li>
      <?php 
      foreach($navs as $nav)
      {
        $class= $nav->id == $category->id ? "class='active'" : "";
        echo "<li {$class}>" . html::a($this->inlink('index', "id={$nav->id}"), $nav->name) . '</li>';
      }
      ?>
      <li>
        <?php echo html::a(helper::createLink('rss', 'index', '', 'xml') . '?type=blog', '<i class="icon icon-rss"></i> RSS', '_blank'); ?>
      </li>
    </ul>
  </div>