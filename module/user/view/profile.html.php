<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <?php include 'side.html.php';?>
  <div class='col-md-9'>
    <table class='table table-form' id='profile'>
      <caption><?php echo $lang->user->profile;?></caption>
      <tr>
        <th class='w-100px'><?php echo $lang->user->realname;?></th>
        <td><?php echo $user->realname;?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->user->email;?></th>
        <td><?php echo $user->email;?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->user->company;?></th>
        <td><?php echo $user->company;?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->user->address;?></th>
        <td><?php echo $user->address;?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->user->zipcode;?></th>
        <td><?php echo $user->zipcode;?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->user->mobile;?></th>
        <td><?php echo $user->mobile;?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->user->phone;?></th>
        <td><?php echo $user->phone;?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->user->qq;?></th>
        <td><?php echo $user->qq;?></td>
      </tr>  
      <tr>
        <th><?php echo $lang->user->gtalk;?></th>
        <td><?php echo $user->gtalk;?></td>
      </tr>  
      <tr>
        <th></th>
        <td><?php echo html::a(inlink('edit'), $lang->user->editProfile, '', "class='btn btn-primary'");?></td>
      </tr>
    </table>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
