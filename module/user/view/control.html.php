<?php include '../../common/view/header.html.php';?>
<div class='row'>
    <?php include './side.html.php';?>
  <div class='span9'>
    <p><?php printf($lang->user->control->welcome, $this->app->user->account);?></p>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
