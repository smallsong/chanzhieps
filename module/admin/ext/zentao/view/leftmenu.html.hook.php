<?php $giftHtml = '<p>' . trim(html::a($this->createLink('gift', 'manage'), $lang->admin->manageGift, 'mainwin')) . '</p>';?>
<?php $linkHtml = '<p>' . trim(html::a($this->createLink('user', 'checkApply'), $lang->admin->checkApply, 'mainwin')) . '</p>';?>
<?php $appHtml  = '<p>' . trim(html::a($this->createLink('extension', 'browseApps'), $lang->admin->browseApps, 'mainwin')) . '</p>';?>
<?php $logHtml  = '<p>' . trim(html::a($this->createLink('user', 'extensionLog'), $lang->admin->extensionLog, 'mainwin')) . '</p>';?>
<?php $payHtml  = '<p>' . trim(html::a($this->createLink('user', 'paypal'), $lang->admin->paypalList, 'mainwin')) . '</p>';?>
<?php $dataHtml = '<p>' . trim(html::a($this->createLink('data', 'index'), $lang->admin->businessData, 'mainwin')) . '</p>';?>
<?php $helpHtml = '<p>' . trim(html::a($this->createLink('help', 'export'), $lang->admin->exportHelp, 'mainwin')) . '</p>';?>
<script type='text/javascript'>
$(function(){
    $('#basic').append("<?php echo trim($giftHtml)?>");
    $('#basic').append("<?php echo trim($linkHtml)?>");
    $('#basic').append("<?php echo trim($appHtml)?>");
    $('#basic').append("<?php echo trim($logHtml)?>");
    $('#basic').append("<?php echo trim($payHtml)?>");
    $('#basic').append("<?php echo trim($dataHtml)?>");
    $('#basic').append("<?php echo trim($helpHtml)?>");
})
</script>
