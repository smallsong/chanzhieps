<?php 
include '../../common/view/header.html.php';
$contact    = json_decode($this->config->company->contact);
?>
<?php $common->printPositionBar($this->app->getModuleName());?>
<div class='widget widget-category radius'>
  <h4 class='radius-top'><?php echo $company->name;?></h4>
  <div class='content'>
    <p><?php echo $company->content;?></p>
    <br/>
    <address>
      <?php foreach($contact as $item => $value):?>
      <?php if($value == "") continue;?>
      <strong><?php echo $lang->company->$item;?>:</strong><?php echo $value;?><br/>
      <?php endforeach;?>
    </address>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>
