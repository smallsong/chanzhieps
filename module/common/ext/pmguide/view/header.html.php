<?php include '../../../../common/view/header.lite.html.php';?>
<div id='topbar'><?php $this->guide->printTopBar($modules);?></div>
<div id='header'>
  <div id='logo' ><?php $config->features->logo ? print("<a href=http://{$app->site->domain}>" . html::image($app->site->fullLogoURL) . "</a>") : print($app->site->name);?></div>
  <div id='slogan'><?php echo $app->site->slogan;?></div>
</div>
