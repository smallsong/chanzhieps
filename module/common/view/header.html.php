<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php 
include 'header.lite.html.php';
if(isset($config->site->logo)) $logo = json_decode($this->config->site->logo);
js::set('lang', $lang->js);
?>
<div class="container">
  <div id="topbar" class="row">  
    <div id="topnav-menu" class="pull-right">
      <?php echo commonModel::printTopBar();?>
    </div>
  </div>
  <div class="masthead">
    <div class="row">
    <div class="span4"><?php if(isset($logo)):?><img class="logo" src="<?php echo $logo->webPath?>"/><?php endif;?></div>
       <div class="span8">
         <div class="slogan">
           <h3><?php echo $config->company->name;?></h3>
           <?php echo $this->config->site->slogan;?> 
         </div>
       </div>
    </div>
    <?php echo commonModel::createFrontMenu();?>
  </div>
