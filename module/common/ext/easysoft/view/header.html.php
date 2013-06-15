<?php include '../../../view/bootstrapheader.lite.html.php';?>
  <div class='container'>
    <div id='docbody'>
    <div id='logobox'><?php $config->features->logo and $app->site->logo ? print(html::a("http://{$app->site->domain}", html::image($app->site->fullLogoURL))) : print($app->site->name);?></div>
