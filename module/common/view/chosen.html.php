<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php
if($config->debug)
{
    css::import($jsRoot . 'jquery/chosen/min.css');
    js::import($jsRoot . 'jquery/chosen/min.js');
}
?>
<script language='javascript'> 
noResultsMatch = '<?php echo 'No matched results.';?>';
$(document).ready(function()
{
    $("#categories").chosen({no_results_text: noResultsMatch, placeholder_text:' '});
});
</script>
