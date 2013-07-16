<?php 
include '../../common/view/header.html.php';
js::set('currentMenu', "#category" . $category->id);
include '../../common/view/treeview.html.php';
include 'portal.html.php';
include '../../common/view/footer.html.php'; 
