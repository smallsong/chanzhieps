<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <title></title>
</head>
<frameset rows='20, *' framespacing='0' frameborder='0'>
  <frame src='<?php echo inlink('topmenu');?>' scrolling='no'>
  <frameset cols='200, *' framespacing='0' frameborder='0'>
    <frame src='<?php echo inlink('navLeftmenu');?>' scrolling='auto' name='leftwin'>
    <frame src='<?php $currentNav = current($config->admin->navigate); echo inlink('gotoUrl', "siteID={$currentNav['siteID']}&url=" . helper::safe64Encode($this->createLink($currentNav['module'], $currentNav['method'])))?>' name='mainwin' id='mainwin' scrolling='yes'>
  </frameset>
</frameset>
</html>
