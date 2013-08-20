<?php
$config->product->create = new stdclass();
$config->product->create->requiredFields = 'categories, name, content';

$config->product->edit = new stdclass();
$config->product->edit->requiredFields = 'categories, name, content';

$config->product->editor = new stdclass();
$config->product->editor->create = array('id' => 'content', 'tools' => 'simpleTools');
$config->product->editor->edit   = array('id' => 'content', 'tools' => 'simpleTools');
