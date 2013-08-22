  <?php if($moduleMenu) echo '</div>';?>
</div>

<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
	<div class="collapse navbar-collapse navbar-ex6-collapse">
    <div class='navbar-text pull-right'><?php printf($lang->poweredBy, $config->version, $config->version);?></div>
  </div>
</nav>

<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);
?>
</body>
</html>
