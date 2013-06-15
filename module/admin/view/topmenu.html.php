<?php include '../../common/view/header.admin.html.php';?>
<body>
<div class='row'>
  <div class='u-1'  id='topmenu'>
    <?php 
    echo $app->site->name . $lang->colon;
    echo html::a("http://{$app->site->domain}", $lang->admin->previewSite, '_blank');
    echo html::a(inlink('index'), $lang->goback, '_parent');
    ?>
  </div>
</div>
</body>
</html>
