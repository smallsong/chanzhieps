<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
    <div class='row'><div class='u-1'><?php if(isset($layouts)) $this->block->printBlock($layouts, 'footer');?></div></div>
  </div>
  <?php if(empty($_GET['onlybody']) or $_GET['onlybody'] != 'yes'):?>
  <div class='row'> <div class='u-1' id='docend'></div></div>
  <div id='footer'>
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
      </div>
    </div>
    <div class='hidden'><?php if(isset($layouts)) $this->block->printBlock($layouts, 'end');?></div>
  </div>
  <?php endif;?>
  <div class='row'><div class='u-1'><iframe name='hiddenwin' id='hiddenwin' class='<?php $config->debug ? print('debugwin') : print('hidden');?>'></iframe></div></div>
</div>
<script laguage='Javascript'>
<?php $onlybody = (!empty($_GET['onlybody']) and $_GET['onlybody'] == 'yes') ? 'yes' : ''?>
var onlybody = '<?php echo $onlybody?>';
<?php if(isset($pageJS)) echo $pageJS;?>
</script>
</body>
</html>
