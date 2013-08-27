<div class="modal-dialog" style="width:500px;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title"><?php echo $lang->user->changePassword;?></h4>
    </div>
    <div class="modal-body">
      <form method='post' action='<?php echo inlink('changepassword');?>' id='passwordForm' class='form form-inline' >
        <table class='table table-form' style="border:none;">
          <tr>
            <td><?php echo $lang->user->account;?></td>
            <td><?php echo $user->account;?></td>
          </tr>  
          <tr>
            <td><?php echo $lang->user->newPassword;?></td>
            <td><?php echo html::password('password1', '', "class='text-3'");?></td>
          </tr>  
          <tr>
            <td><?php echo $lang->user->password2;?></td>
            <td><?php echo html::password('password2', '', "class='text-3'");?></td>
          </tr>  
          <tr><td colspan='2' class='a-center'><?php echo html::submitButton();?></td></tr>
        </table>
      </form>
    </div>
<!--       <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <?php echo html::submitButton();?>
    </div> -->
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?php if(isset($pageJS)) js::execute($pageJS);?>
