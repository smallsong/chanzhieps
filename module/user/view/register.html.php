<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <div class='u-24-5'>
    <div class='cont-left'>
      <div class='box-title'><?php echo $lang->user->register->welcome;?></div>
      <div class='box-content'><?php echo $lang->user->register->why;?></div>
    </div>
  </div>

  <div class='u-24-19'>
    <form method='post' target='hiddenwin' class='cont bd-none'>
      <table class='table-1'> 
        <caption><?php echo $lang->user->register->lblUserInfo;?></caption>
        <tr>
          <td align='right'><?php echo $lang->user->account;?></td>
          <td><?php echo html::input('account', '', "class='w-200px'") . '<font color="red">*</font>' . $lang->user->register->lblAccount;?></td>
        </tr>  
        <tr>
          <td align='right'><?php echo $lang->user->realname;?></td>
          <td><?php echo html::input('realname', '', "class='w-200px'") . '<font color="red">*</font>';?></td>
        </tr>
        <tr>
        <tr>
          <td align='right'><?php echo $lang->user->company;?></td>
          <td><?php echo html::input('company', '', "class='w-200px'");?></td>
        </tr>
        <tr>
        <tr>
          <td align='right'><?php echo $lang->user->phone;?></td>
          <td><?php echo html::input('phone', '', "class='w-200px'");?></td>
        </tr>  
        <tr>
          <td align='right'><?php echo $lang->user->email;?></td>
          <td><?php echo html::input('email', '', "class='w-200px'") . '<font color="red">*</font>';?></td>
        </tr>  
        <tr>
          <td align='right'><?php echo $lang->user->password;?></td>
          <td><?php echo html::password('password1', '', "class='w-200px'") . '<font color="red">*</font>' . $lang->user->register->lblPassword;?></td>
        </tr>  
        <tr>
          <td align='right'><?php echo $lang->user->password2;?></td>
          <td><?php echo html::password('password2', '', "class='w-200px'") . '<font color="red">*</font>';?></td>
        </tr>  
        <tr><td colspan='2' align='center'>
          <?php 
          echo html::hidden('referer', $referer);
          echo html::submitButton() . html::resetButton();
          ?>
        </td></tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
