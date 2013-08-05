<?php include '../../common/view/header.html.php';?>
<div class='row-fluid'>
  <?php include 'side.html.php';?>
  <div class='span9'>
    <form method='post' target='hiddenwin' class='cont bd-none'>
    <table class='table table-form' id='profile'>
      <caption><?php echo $lang->user->profile;?></caption>
        <tr>
          <td align='right' class='w-60px'><?php echo $lang->user->realname;?></td>
          <td><?php echo $user->realname;?></td>
        </tr>  
        <tr>
          <td align='right'><?php echo $lang->user->email;?></td>
          <td><?php echo $user->email;?></td>
        </tr>  
        <tr>
          <td align='right'><?php echo $lang->user->company;?></td>
          <td><?php echo $user->company;?></td>
        </tr>  
        <tr>
          <td align='right'><?php echo $lang->user->address;?></td>
          <td><?php echo $user->address;?></td>
        </tr>  
        <tr>
          <td align='right'><?php echo $lang->user->zipcode;?></td>
          <td><?php echo $user->zipcode;?></td>
        </tr>  
        <tr>
          <td align='right'><?php echo $lang->user->mobile;?></td>
          <td><?php echo $user->mobile;?></td>
        </tr>  
        <tr>
          <td align='right'><?php echo $lang->user->phone;?></td>
          <td><?php echo $user->phone;?></td>
        </tr>  
        <tr>
          <td align='right'><?php echo $lang->user->qq;?></td>
          <td><?php echo $user->qq;?></td>
        </tr>  
        <tr>
          <td align='right'><?php echo $lang->user->gtalk;?></td>
          <td><?php echo $user->gtalk;?></td>
        </tr>  
        <tr>
          <td colspan='2' class="a-center">
            <?php echo html::a(inlink('edit'), $lang->user->editProfile, '', 'class="btn btn-primary"');?>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
