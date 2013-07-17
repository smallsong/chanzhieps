  <?php if($moduleMenu) echo '</div>';?>
  </div>    
</div>

<div class="navbar navbar-fixed-bottom">
  <div class='navbar-inner'>
    <div class='container-fluid'>
      <div class='navbar-text pull-right'><?php printf($lang->poweredBy, $config->version);?></div>
    </div>
  </div>
</div>

<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if($config->debug) js::import($jsRoot . 'jquery/form/xirang.js');
if(isset($pageJS)) js::execute($pageJS);
?>
</body>
</html>
