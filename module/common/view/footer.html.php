  <div class="navbar navbar-fixed-bottom">
    <div class='navbar-inner'>
      <div class='container-fluid'>
        <div class='navbar-text pull-right'>
        <?php 
        echo "&copy; {$config->company->name} {$config->site->start}-" . date('Y');
        echo $config->site->icp;
        ?>
        </div>
      </div>
    </div>
  </div>

</div>
