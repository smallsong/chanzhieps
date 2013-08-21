<?php include '../../common/view/header.html.php';?>
<div class='row'>
  <?php include './side.html.php';?>
  <div class='col-md-9'>
    <table class='table table-bordered'>
      <caption><?php printf($lang->user->control->welcome, $this->app->user->realname);?></caption>
      <tr><td></td></tr>
    </table>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
