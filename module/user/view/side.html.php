  <div class='span3' id="leftmenu">
    <table class='table table-bordered'>
      <caption><h4><?php echo $lang->user->control->common;?></h4> </caption>
      <?php
      ksort($lang->user->control->menus);
      foreach($lang->user->control->menus as $menu)
      {
          $active = "";
          list($label, $module, $method) = explode('|', $menu);
          if($module == $this->app->getModuleName() && $method == $this->app->getMethodName()) $active = "class='active'";
          echo "<tr><td {$active}>" . html::a($this->createLink($module, $method), $label) . '</td></tr>';
      }
      ?>
    </table>
  </div>

