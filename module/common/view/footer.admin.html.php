<?php
if($config->debug)
{
    js::import($jsRoot . 'jquery/form/min.js');
    js::import($jsRoot . 'jquery/form/xirang.js');
}
if(isset($pageJS)) js::execute($pageJS);
?>
</body>
</html>
