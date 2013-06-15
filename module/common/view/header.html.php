<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php include 'header.lite.html.php';?>
<?php if(empty($_GET['onlybody']) or $_GET['onlybody'] != 'yes'):?>
<div class='row' id='topbar'><div class='u-1 a-right'><?php common::printTopBar();?></div></div>
<table class='table-1' id='header'>
  <tr valign='middle' class='a-center'>
    <td id='logobox' ><?php $config->features->logo and $app->site->logo ? print("<a href=http://{$app->site->domain}>" . html::image($app->site->fullLogoURL) . '</ a>'): print($app->site->name);?></td>
    <td id='sloganbox'><h1><?php echo $app->site->slogan;?></h1></td>
    <td id='searchbox'><?php common::printSearch();?></td>
  </tr>
</table>

<div class='row' id='navbar'><?php common::printNavBar()?></div>
<?php endif;?>
<div id='docbody'>
