<?php if($config->debug):?>
<link rel='stylesheet' href='<?php echo $siteTheme;?>treeview.css' type='text/css' />
<script src='<?php echo $jsRoot;?>jquery/treeview/min.js' type='text/javascript'></script>
<?php endif;?>
<script language='javascript'>$(function() { $(".tree").treeview({ persist: "cookie", collapsed: true, unique: true }) })</script>
