<?php include '../../common/view/header.html.php';?>
<div class='row-fluid'>
  <div class='span12'>
    <form method='post' id='ajaxForm' class='form-inline'>
      <table class='table table-form table-bordered'> 
        <caption><?php echo $lang->user->register->welcome;?></caption>
        <tr>
          <th class='w-100px'><?php echo $lang->user->account;?></th>
          <td><?php echo html::input('account', '', "class='text-3' autocomplete='off' placeholder='" . $lang->user->register->lblAccount . "'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->realname;?></th>
          <td><?php echo html::input('realname', '', "class='text-3'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->email;?></th>
          <td><?php echo html::input('email', '', "class='text-3' autocomplete='off'") . '';?></td>
        </tr> 
        <tr>
          <th><?php echo $lang->user->password;?></th>
          <td><?php echo html::password('password1', '', "class='text-3' autocomplate='off' placeholder='" . $lang->user->register->lblPassword . "'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->password2;?></th>
          <td><?php echo html::password('password2', '', "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->company;?></th>
          <td><?php echo html::input('company', '', "class='text-3'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->phone;?></th>
          <td><?php echo html::input('phone', '', "class='text-3'");?></td>
        </tr>  
        <tr>
          <th></th>
          <td><?php echo html::submitButton($lang->register) . html::hidden('referer', $referer);?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>
