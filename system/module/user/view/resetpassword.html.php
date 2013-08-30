<?php include '../../common/view/header.html.php';?>
<form method='post' id='ajaxForm'>
<table align='center' class='table table-form'>
    <caption><?php echo $lang->user->resetPassword->caption;?></caption>
    <tr><th><?php echo $lang->user->account;?></th><td><?php echo html::input('account')?></td></tr>
    <tr><th><?php echo $lang->user->email;?></th><td><?php echo html::input('email')?></td></tr>
    <tr align='center'><td colspan='2'><?php echo html::submitButton($lang->user->submit);?></td></tr>
</table>  
</form>
<?php include '../../common/view/footer.html.php';?>
