  <hr/>
  <footer>
    <div class='a-center mb-20px'>
      <?php 
      echo "&copy; {$config->company->name} {$config->site->copyright}-" . date('Y') . '&nbsp;&nbsp;';
      echo $config->site->icp;
      printf($lang->poweredBy, $config->version, $config->version);
      ?>
    </div>
  </footer>
   
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);
?>
</div>
