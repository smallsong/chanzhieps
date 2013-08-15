<?php 
include '../../common/view/header.html.php';
?>
<?php $common->printPositionBar($this->app->getModuleName());?>
<div class='widget radius'>
  <h4 class='radius-top'><?php echo $company->name;?></h4>
  <div class='content'>
    <p><?php echo $company->content;?></p>
    <br/>
    <dl id='contact'>
      <?php foreach($contact as $item => $value):?>
      <dt class='w-p5'><?php echo $lang->company->$item;?>:</dt>
      <dd class='w-p90'><?php echo $value;?></dd>
      <?php endforeach;?>
    <div class='c-both'></div>
    </dl>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>
