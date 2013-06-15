<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <title><?php echo $app->site->name;?></title>
</head>
<frameset rows='20, *' framespacing='0' frameborder='0'>
  <frame src='<?php echo inlink('topmenu');?>' scrolling='no'>
  <frameset cols='200, *' framespacing='0' frameborder='0'>
    <frame src='<?php echo inlink('leftmenu');?>' scrolling='auto' name='leftwin'>
    <frame src='<?php echo $this->createLink('comment', 'getlatest');?>' name='mainwin' id='mainwin' scrolling='yes'>
  </frameset>
</frameset>
</html>
