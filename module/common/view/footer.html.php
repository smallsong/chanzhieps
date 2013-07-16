  <hr/>
  <footer>
   <?php 
   echo "&copy; {$config->company->name} {$config->site->copyrightStart}-" . date('Y');
   echo $config->site->icp;
   ?>
  </footer>
   
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if($config->debug) js::import($jsRoot . 'jquery/form/xirang.js');
if(isset($pageJS)) js::execute($pageJS);
?>
</div>
