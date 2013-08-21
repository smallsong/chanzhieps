<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <?php include './side.html.php';?>
  <div class='col-md-9'>
    <form method='post' id='ajaxForm' class='form form-inline'>
      <table class='table table-form table-bordered'>
        <caption><?php echo $lang->user->editProfile;?></caption>
        <tr>
          <th class='w-100px'><?php echo $lang->user->realname;?></th>
          <td><?php echo html::input('realname', $user->realname, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->email;?></th>
          <td><?php echo html::input('email', $user->email, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->password;?></th>
          <td><?php echo html::password('password1', '', "class='text-3' autocomplete='off'") . $lang->user->control->lblPassword;?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->password2;?></th>
          <td><?php echo html::password('password2', '', "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->company;?></th>
          <td><?php echo html::input('company', $user->company, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->address;?></th>
          <td><?php echo html::input('address', $user->address, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->zipcode;?></th>
          <td><?php echo html::input('zipcode', $user->zipcode, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->mobile;?></th>
          <td><?php echo html::input('mobile', $user->mobile, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->phone;?></th>
          <td><?php echo html::input('phone', $user->phone, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->qq;?></th>
          <td><?php echo html::input('qq', $user->qq, "class='text-3'");?></td>
        </tr>  
        <tr>
          <th><?php echo $lang->user->gtalk;?></th>
          <td><?php echo html::input('gtalk', $user->gtalk, "class='text-3'");?></td>
        </tr>  
        <tr><th></th><td><?php echo html::submitButton();?></td></tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
