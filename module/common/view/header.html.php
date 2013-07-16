<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php 
include 'header.lite.html.php';
if(isset($config->site->logo)) $logo = json_decode($this->config->site->logo);
js::set('lang', $lang->js);
?>
<div class="container" style="padding-top:20px;">
  <div class="masthead">
    <div class="row">
      <div class="span3">
        <?php if(isset($logo)):?><img class="logo" src="<?php echo $logo->webPath?>"/><?php endif;?>
      </div>
      <div class="span9">
        <span id="topnav-menu" class="pull-right"> <?php echo commonModel::printTopBar();?> </span>
        <div class="slogan">
          <h3><?php echo $config->company->name;?></h3>
          <span><?php echo $this->config->site->slogan;?> </span>
        </div>
      </div>
    </div>
    <?php echo commonModel::createFrontMenu();?>
  </div>
