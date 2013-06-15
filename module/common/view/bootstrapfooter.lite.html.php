    <?php js::import($jsRoot . 'jquery/bootstrap/bootstrap.min.js', $config->version);?>
    <div class='hidden'><iframe name='hiddenwin' id='hiddenwin' class='<?php $config->debug ? print('debugwin') : print('hidden');?>'></iframe></div>
  </body>
</html>
