<?php include '../../common/view/header.html.php';?>
<div class='row-fluid'>
  <?php include './side.html.php';?>
  <div class='span9'>
    <table class='table table-bordered'>
      <caption><?php printf($lang->user->control->welcome, $this->app->user->realname);?></caption>
      <tr><td></td></tr>
    </table>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
