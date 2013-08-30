<?php include '../../../../common/view/header.html.php'; ?>
<div class='row-fluid'>
  <div class='span3'>
    <iframe frameborder='0' src='<?php echo inLink('menu')?>' scrolling='auto' width='100%' name='menu' id='menu' onload="this.height=this.contentWindow.document.documentElement.scrollHeight"></iframe>
  </div>
  <div class='span9'>
  <iframe frameborder='0'src='<?php echo inLink('read', "articleID=78472")?>' scrolling='no' height='800px' width='100%' name='content' id='content' onload="this.height=this.contentWindow.document.documentElement.scrollHeight"></iframe>
  </div>
</div>
<?php include '../../../../common/view/footer.html.php'; ?>
