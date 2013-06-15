<?php 
$linkHtml  = '<p>' . html::a($this->createLink('pms', 'manageOrder'), $lang->admin->manageOrder, 'mainwin') . '</p>';
$linkHtml .= '<p>' . html::a($this->createLink('pms', 'manageDomain'), $lang->admin->manageDomain, 'mainwin') . '</p>';
?>
<script type='text/javascript'>
$(function()
{
    $('#basic').append(<?php echo json_encode($linkHtml)?>);
})
</script>
