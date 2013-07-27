<?php include 'header.lite.html.php';?>
<?php js::set('lang', $lang->js);?>
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <?php echo html::a($this->createLink($this->config->default->module), $lang->xirangEPS, '', "class='brand'");?>
      <?php echo commonModel::createMainMenu($this->moduleName);?>
      <?php echo commonModel::createManagerMenu();?>
     </div>
  </div>
</div>

<div class="page-header-primary">
  <div class="page-header-main">
    <h1>
      <?php echo $this->moduleName;?>
    </h1>
  </div>
</div>

<div class="container-fluid">
  <div class="row-fluid">
    <?php 
    $moduleMenu = commonModel::createModuleMenu($this->moduleName);
    if($moduleMenu) echo "<div class='span2'>$moduleMenu</div>\n<div class='span10'>\n";
    ?>
