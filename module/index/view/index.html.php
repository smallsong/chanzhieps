<?php include '../../common/view/header.html.php'; ?>
<?php include '../../common/view/treeview.html.php'; ?>
<?php
$viewFile = $this->session->site->type . '.html.php';
include $viewFile;
?>
<?php include '../../common/view/footer.html.php'; ?>
