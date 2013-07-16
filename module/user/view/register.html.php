<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <div class='span9'>
    <h3><?php echo $lang->user->register->welcome;?></h3>
    <form method='post' id="ajaxForm" class="form-inline">
      <table class='table table-form'> 
        <caption><?php echo $lang->user->register->lblUserInfo;?></caption>
        <tr>
          <td class="w-100px"><?php echo $lang->user->account;?></td>
          <td><?php echo html::input('account', '', "class='text-3' autocomplete='off' placeholder='" . $lang->user->register->lblAccount . "'");?></td>
        </tr>  
        <tr>
          <td><?php echo $lang->user->realname;?></td>
          <td><?php echo html::input('realname', '', "class='text-3'");?></td>
        </tr>
        <tr>
          <td><?php echo $lang->user->company;?></td>
          <td><?php echo html::input('company', '', "class='text-3'");?></td>
        </tr>
        <tr>
        <tr>
          <td><?php echo $lang->user->phone;?></td>
          <td><?php echo html::input('phone', '', "class='text-3'");?></td>
        </tr>  
        <tr>
          <td><?php echo $lang->user->email;?></td>
          <td><?php echo html::input('email', '', "class='text-3' autocomplete='off'") . '';?></td>
        </tr>  
        <tr>
          <td><?php echo $lang->user->password;?></td>
          <td><?php echo html::password('password1', '', "class='text-3' autocomplate='off' placeholder='" . $lang->user->register->lblPassword . "'");?></td>
        </tr>  
        <tr>
          <td><?php echo $lang->user->password2;?></td>
          <td><?php echo html::password('password2', '', "class='text-3'");?></td>
        </tr>  
        <tr>
          <td colspan='2' class='a-enter'>
          <?php 
          echo html::hidden('referer', $referer);
          echo html::submitButton() . html::resetButton();
          ?>
          </td>
        </tr>
      </table>
    </form>
  </div>
<?php include '../../common/view/side.html.php'; ?>
</div>
<?php include '../../common/view/footer.html.php'; ?>
