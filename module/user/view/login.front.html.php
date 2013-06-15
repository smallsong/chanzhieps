<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <div class='u-24-5'>
    <div class='cont-left'>
      <div class='box-title'><?php echo $lang->user->login->welcome;?></div>
      <div class='box-content'><?php echo $lang->user->login->why;?></div>  
    </div> 
  </div>
  <div class='u-24-19'>
    <div class='cont'><?php include './blockuserform.html.php';?></div>
  </div>
</div>  
<?php include '../../common/view/footer.html.php';?>
