<div class='col-md-3' id='leftmenu'>
  <table class='table table-bordered'>
    <caption><?php echo $lang->user->control->common;?></caption>
    <?php
    ksort($lang->user->control->menus);
    foreach($lang->user->control->menus as $menu)
    {
        $class = 'a-center';
        list($label, $module, $method) = explode('|', $menu);
        if($module == $this->app->getModuleName() && $method == $this->app->getMethodName()) $class .= ' active';
        echo "<tr><td class='$class'>" . html::a($this->createLink($module, $method), $label) . '</td></tr>';
    }
    ?>
  </table>
</div>
