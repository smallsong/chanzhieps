<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php css::import($jsRoot . 'jquery/chosen/min.css');?>
<?php js::import($jsRoot . 'jquery/chosen/min.js');?>

<script language='javascript'> 
$(document).ready(function()
{
    $(".chosen").chosen({no_results_text: '<?php echo $lang->noResultsMatch;?>', placeholder_text:' '});
});
</script>
