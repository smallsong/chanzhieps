<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <div class='u-24-17'>
    <form method='post' target='hiddenwin' action='<?php echo $this->createLink('user', 'addAccount');?>'  class='cont bd-none'>
      <table class='table-1'> 
        <caption><?php echo $lang->user->register->lblUserInfo;?></caption>
        <tr>
          <td align='right'><?php echo $lang->user->account;?></td>
          <td><?php echo html::input('account', '', "class='w-200px'") . '<font color="red">*</font>' . $lang->user->register->lblAccount;?></td>
        </tr>  
        <tr>
          <td align='right'><?php echo $lang->user->realname;?></td>
          <td><?php echo html::input('realname', $user['name'], "class='w-200px'") . '<font color="red">*</font>';?></td>
        </tr>
        <tr>
          <td align='right'><?php echo $lang->user->email;?></td>
          <td><?php echo html::input('email', '', "class='w-200px'") . '<font color="red">*</font>';?></td>
        </tr>  
        <tr><td colspan='2' align='center'>
          <?php 
          echo html::hidden('openID', $user['id']);
          echo html::submitButton() . html::resetButton();
          ?>
        </td></tr>
      </table>
    </form>
  </div>

  <div class='u-24-7 pl-10px'>
    <div class='cont-right'>
      <div class='box-title'><?php echo '绑定已有账户：';?></div>
      <div class='box-content'>
        <form method='post' target='hiddenwin' action='<?php echo $this->createLink('user', 'bind');?>' class='bd-none'>
          <table class='table-1' style='border:none'>
            <tr>
              <th class='w-100px'><nobr><?php echo $lang->account;?></nobr></th>
              <td><input type='text' name='account' class='w-100px' /></td>
            </tr>
            <tr>
              <th><?php echo $lang->password;?></th>
              <td><nobr><input type='password' name='password' class='w-100px' /></nobr></td>
            </tr>
            <tr>
              <td></td>
              <td>
                <?php 
                echo html::submitButton($lang->login) . "<br />";
                echo html::hidden('openID', $user['id']);
                echo html::a($this->createLink('user', 'register'), $lang->register, '', "class='red'") . '<br />';
                echo html::a($this->createLink('user', 'resetpassword'), $lang->forgotPassword, '');
                ?>
              </td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
