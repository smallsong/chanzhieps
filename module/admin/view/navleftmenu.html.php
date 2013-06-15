<?php include '../../common/view/header.admin.html.php';?>
<ol>
  <?php
  foreach($config->admin->navigate as $navigate)
  {
    echo '<li>' . html::a(inlink('gotoUrl', "siteID={$navigate['siteID']}&url=" . helper::safe64Encode($this->createLink($navigate['module'], $navigate['method'], isset($navigate['params']) ? $navigate['params'] : ''))), $lang->admin->$navigate['name'], 'mainwin') . '</li>';
  }
  ?>
</ol>
<?php include '../../common/view/footer.admin.html.php';?>
