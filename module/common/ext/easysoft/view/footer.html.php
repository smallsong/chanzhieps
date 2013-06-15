        <div id='icp' class='f-right'>
        <?php 
        echo "&copy {$app->site->name} {$config->copyright->start}-" . date('Y') ;
        if($config->copyright->about)     echo ' ' . html::a($config->copyright->about, $lang->aboutus, '_blank');
        if(isset($config->copyright->hr)) echo ' ' . html::a($config->copyright->hr,    $lang->hr, '_blank');
        echo $lang->icp;
        ?>
        </div>

      </div> 
    </div>

<?php include '../../../view/bootstrapfooter.lite.html.php';?>
