<?php
$config->article->digest      = 200;
$config->article->indexCount  = 10;
$config->article->moduleCount = 10;
$config->article->create      = new stdClass();
$config->article->editor      = new stdclass();

$config->article->create->requiredFields = 'title, content';
$config->article->editor->create = array('id' => 'content', 'tools' => 'simpleTools');
$config->article->editor->edit   = array('id' => 'content', 'tools' => 'simpleTools');
