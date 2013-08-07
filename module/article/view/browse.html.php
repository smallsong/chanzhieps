<?php 
include '../../common/view/header.html.php';
js::set('currentMenu', "#category" . $category->id);

$categoryPath = array_keys($category->pathNames);
js::set('categoryPath',  json_encode($categoryPath));

include '../../common/view/treeview.html.php';
include 'portal.html.php';
include '../../common/view/footer.html.php'; 
