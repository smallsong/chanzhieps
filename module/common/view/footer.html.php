  <hr/>
  <footer class='a-center'>
   <?php 
   echo "&copy; {$config->company->name} {$config->site->copyrightStart}-" . date('Y') . '&nbsp;&nbsp;';
   echo $config->site->icp;
   printf($lang->poweredBy, $config->version, $config->version);
   ?>
  </footer>
   
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);
?>
</div>
