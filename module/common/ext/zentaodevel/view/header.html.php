<?php include '../../../view/bootstrapheader.lite.html.php';?>
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="brand" href="#"><?php echo $app->site->name;?></a>
        <div class="nav-collapse collapse">
          <?php common::printNavBar()?>
        </div>
      </div>
    </div>
  </div>

  <div class='container'>
