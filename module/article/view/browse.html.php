<?php 
include '../../common/view/header.html.php';
include '../../common/view/treeview.html.php';
$common->printPositionBar($module);
$viewFile = $this->session->site->type . '.html.php';
include $viewFile;
include '../../common/view/footer.html.php'; 
