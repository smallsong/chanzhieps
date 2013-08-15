<?php 
include '../../common/view/header.html.php';
?>
<?php $common->printPositionBar($this->app->getModuleName());?>
<div class='widget radius'>
  <h4 class='radius-top'><?php echo $company->name;?></h4>
  <div class='content'>
    <p><?php echo $company->content;?></p>
    <br/>
    <?php foreach($contact as $item => $value):?>
    <dl id='contact'>
      <dt class='w-p5'><?php echo $lang->company->$item;?>:</dt>
      <dd class='w-p90'><?php echo $value;?></dd>
      <div class='c-both'></div>
    </dl>
    <?php endforeach;?>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>
