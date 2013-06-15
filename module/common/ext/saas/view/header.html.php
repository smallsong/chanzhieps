<?php include '../../../view/header.lite.html.php';?>
<?php if(empty($_GET['onlybody']) or $_GET['onlybody'] != 'yes'):?>
<div class='row' id='topbar'>
<?php $companies = $this->dao->select('COUNT(*) AS companies')->from(TABLE_PMSSITE)->fetch('companies', false);?>
  <div class='u-5-2'><div class='cont'><?php echo sprintf($lang->common->count, $companies);?></div></div>
  <div class='u-5-3 a-right'><div class='cont'><?php common::printTopBar();?></div></div>
</div>
<div id='header'>
  <h1 class='hidden'><?php echo $lang->common->title;?></h1>
  <div id='logobox' ><?php $config->features->logo ? print(html::image($app->site->fullLogoURL)) : print($app->site->name);?></div>
  <div id="navbar">
    <ul>
	  <li><a href="/"><img src="<?php echo $themeRoot?>default/images/saas/homepage.png" /><?php echo $lang->common->index;?></a></li>
      <li><a href="/pms-plans.html"><img src="<?php echo $themeRoot?>default/images/saas/plan.png" /><?php echo $lang->common->priceList;?></a></li>
      <li><a href="/help-index.html"><img src="<?php echo $themeRoot?>default/images/saas/help.png" /><?php echo $lang->common->help;?></a></li>
      <li><a href="/forum-board-1406.html"><img src="<?php echo $themeRoot?>default/images/saas/support.png" /><?php echo $lang->common->support;?></a></li>
      <li><a href="/user-control.html"><img src="<?php echo $themeRoot?>default/images/saas/user.png" /><?php echo $lang->common->my;?></a></li>
      <li><a href="http://blog.zentao.net/article-browse-1201.html"><img src="<?php echo $themeRoot?>default/images/saas/dynamic.png" /><?php echo $lang->common->updateLog;?></a></li>
      <li><a href="/forum"><img src="<?php echo $themeRoot?>default/images/saas/forum.png" /><?php echo $lang->common->forum;?></a></li>
    </ul>
  </div>
  <?php if($app->site->code == '5upm') echo "<div class='contact'><img src='{$themeRoot}site/images/5upm/contact.png' /></div>";?>
</div>
<?php endif;?>
<div id='docbody'>
