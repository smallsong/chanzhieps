<?php 
include '../../common/view/header.html.php';
$contact    = json_decode($this->config->company->contact);
?>
<div class="row">
  <div class="span9">
    <?php $common->printPositionBar($this->app->getModuleName());?>
    <h1><?php echo $company->name;?></h1>
    <p><?php echo $company->content;?></p>
    <br/>
    <address>
      <?php foreach($contact as $item => $value):?>
      <?php if($value == "") continue;?>
      <strong><?php echo $lang->company->$item;?>:</strong><?php echo $value;?><br/>
      <?php endforeach;?>
    </address>
  </div>
<?php include '../../common/view/side.html.php';?>
</div>
<?php include '../../common/view/footer.html.php'; ?>
