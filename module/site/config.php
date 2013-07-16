<?php
if(!isset($config->site)) $config->site = new stdclass();
$config->site->editor      = new stdclass();
$config->site->editor->setbasic= array('id' => 'desc', 'tools' => 'simpleTools');
