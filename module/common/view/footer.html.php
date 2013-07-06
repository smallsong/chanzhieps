  <hr/>
  <footer>
   <?php 
   echo "&copy; {$config->company->name} {$config->site->copyrightStart}-" . date('Y');
   echo $config->site->icp;
   ?>
   </footer>
<?php if(isset($pageJS)) js::execute($pageJS); ?>
</div>
