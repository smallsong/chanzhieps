  <?php if($moduleMenu) echo '</div>';?>
  <div class='c-both'></div>
  </div>    
</div>

<div class="navbar navbar-fixed-bottom">
  <div class='navbar-inner'>
    <div class='container-fluid'>
      <div class='navbar-text pull-right'><?php printf($lang->poweredBy, $config->version, $config->version);?></div>
    </div>
  </div>
</div>

<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);
?>
</body>
</html>
