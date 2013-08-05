<?php include '../../common/view/header.html.php';?>
<div class='row-fluid'>
<?php include './side.html.php';?>
  <div class='span9'>
    <form method='post' id="ajaxForm" class="form form-inline" >
      <table class='table table-form'>
        <caption><?php echo $lang->user->editProfile;?></caption>
        <tr>
          <td><?php echo $lang->user->realname;?></td>
          <td><?php echo html::input('realname', $user->realname, "class='text-3'");?></td>
        </tr>  
        <tr>
          <td><?php echo $lang->user->email;?></td>
          <td><?php echo html::input('email', $user->email, "class='text-3'");?></td>
        </tr>  
        <tr>
          <td><?php echo $lang->user->company;?></td>
          <td><?php echo html::input('company', $user->company, "class='text-3'");?></td>
        </tr>  
        <tr>
          <td><?php echo $lang->user->mobile;?></td>
          <td><?php echo html::input('mobile', $user->mobile, "class='text-3'");?></td>
        </tr>  
        <tr>
          <td><?php echo $lang->user->phone;?></td>
          <td><?php echo html::input('phone', $user->phone, "class='text-3'");?></td>
        </tr>  
        <tr>
          <td><?php echo $lang->user->address;?></td>
          <td><?php echo html::input('address', $user->address, "class='text-3'");?></td>
        </tr>  
        <tr>
          <td><?php echo $lang->user->zipcode;?></td>
          <td><?php echo html::input('zipcode', $user->zipcode, "class='text-3'");?></td>
        </tr>  
        <tr>
          <td><?php echo $lang->user->qq;?></td>
          <td><?php echo html::input('qq', $user->qq, "class='text-3'");?></td>
        </tr>  
        <tr>
          <td><?php echo $lang->user->gtalk;?></td>
          <td><?php echo html::input('gtalk', $user->gtalk, "class='text-3'");?></td>
        </tr>  
        <tr>
          <td><?php echo $lang->user->password;?></td>
          <td><?php echo html::password('password1', '', "class='text-3'") . $lang->user->control->lblPassword;?></td>
        </tr>  
        <tr>
          <td><?php echo $lang->user->password2;?></td>
          <td><?php echo html::password('password2', '', "class='text-3'");?></td>
        </tr>  
        <tr><td colspan='2' class='a-center'><?php echo html::submitButton() . html::resetButton();?></td></tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
