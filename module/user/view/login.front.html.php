<?php include '../../common/view/header.html.php';?>
<div class='row-fluid'>
  <div class='span12'>
    <form method="post" id='ajaxForm' class='form-inline'>
      <table class='table table-bordered table-form'>
        <caption><?php echo $lang->user->login->welcome;?></caption>
        <tr>
          <th class='w-100px'><?php echo $lang->user->account;?></th>
          <td><?php echo html::input('account','',"class='text-3' placeholder='{$lang->user->inputAccountOrEmail}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->user->password;?></th>
          <td><?php echo html::password('password','',"class='text-3' placeholder='{$lang->user->inputPassword}'");?></td>
        </tr>
        <tr>
          <td></td>
          <td>
            <?php echo html::submitButton($lang->user->login->common, 'btn btn-primary');?>
            <span id='responser' class='text-center'></span>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>  
<?php include '../../common/view/footer.html.php';?>
