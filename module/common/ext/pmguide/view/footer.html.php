<div id='divider'></div>
<div class='row'>
  <div class='u-1'>
    <div id='copyright' class='a-center'>
    <?php 
    echo "&copy {$app->site->name} {$config->copyright->start}-" . date('Y') ;
    if($config->copyright->about)     echo ' ' . html::a($config->copyright->about, $lang->aboutus, '_blank');
    if(isset($config->copyright->hr)) echo ' ' . html::a($config->copyright->hr,    $lang->hr, '_blank');
    echo $lang->icp;
    ?>
    </div>
    <div class='hidden'><?php if(isset($layouts)) $this->block->printBlock($layouts, 'end');?></div>
  </div>
</div>
</div>
</body>
</html>
