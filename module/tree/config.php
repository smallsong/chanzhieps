<?php
if(!isset($config->tree)) $config->tree = new stdclass();

$config->tree->edit = new stdClass();
$config->tree->edit->requiredFields = 'parent, name';
