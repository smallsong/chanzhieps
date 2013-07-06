<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php 
include 'header.lite.html.php';
$logo = json_decode($this->config->site->logo);
?>
<div class="container">
  <div class="masthead">
    <div class="row">
       <div class="span4"><img class="logo" src="<?php echo $logo->webPath?>"/></div>
       <div class="span8">
         <div class="slogan">
           <h3><?php echo $config->company->name;?></h3>
           <?php echo $this->config->site->slogan;?> 
         </div>
       </div>
    </div>
    <?php echo commonModel::createFrontMenu();?>
  </div>
