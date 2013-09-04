  <hr/>
  <footer>
    <div class='a-center mb-20px'>
      <?php 
      echo "&copy; {$config->company->name} {$config->site->copyright}-" . date('Y') . '&nbsp;&nbsp;';
      echo $config->site->icp;
      printf($lang->poweredBy, $config->version, $config->version);
      echo html::a(helper::createLink('rss', 'index', '', 'xml') . '?type=blog', html::image($themeRoot . 'default/images/main/rss.png'), '_blank');
      ?>
    </div>
  </footer>
   
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);
?>
</div>
</body>
</html>
