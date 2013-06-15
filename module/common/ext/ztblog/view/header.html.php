<?php include '../../../view/header.lite.html.php';?>
<?php if(empty($_GET['onlybody']) or $_GET['onlybody'] != 'yes'):?>
<table class='table-1' id='header'>
  <tr valign='middle'><td id='sloganbox'><h1 class='a-left'><?php echo $app->site->slogan;?></h1></td></tr>
</table>
<?php endif;?>

<div class='row' id='navbar'><?php common::printNavBar()?></div>
<div id='docbody'>
