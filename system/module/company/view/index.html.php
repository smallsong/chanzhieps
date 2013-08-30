<?php 
include '../../common/view/header.html.php';
?>
<?php $common->printPositionBar($this->app->getModuleName());?>
<div class='box radius'>
  <div class='content'>
    <p><?php echo $company->content;?></p>
    <br/>
    <div id='contact'>
      <?php foreach($contact as $item => $value):?>
      <dl>
        <dt><?php echo $lang->company->$item;?>:</dt>
        <dd><?php echo $value;?></dd>
        <div class='c-both'></div>
      </dl>
      <?php endforeach;?>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>
