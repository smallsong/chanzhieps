<?php include '../../common/view/header.html.php';?>
<form method="post" target="hiddenwin">
<table align="center" class="table-1" style="border:none">
    <div class="box-title"><?php echo $lang->user->resetPassword->caption;?></div>
    <tr><th><?php echo $lang->user->account;?></th><td><?php echo html::input("account")?></td></tr>
    <tr><th><?php echo $lang->user->email;?></th><td><?php echo html::input("email")?></td></tr>
    <tr align="center"><td colspan="2"><?php echo html::submitButton($lang->user->submit);?></td></tr>
</table>  
</form>

<?php include '../../common/view/footer.html.php';?>
