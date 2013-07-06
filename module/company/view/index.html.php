<?php 
include '../../common/view/header.html.php';
//$common->printPositionBar($this->app->getModuleName());
?>
<div class="row">
  <div class="span9">
    <h1><?php echo $company->name;?></h1>
    <p><?php echo $company->desc;?></p>
  </div>
<?php include '../../common/view/side.html.php';?>
</div>
<?php include '../../common/view/footer.html.php'; ?>
