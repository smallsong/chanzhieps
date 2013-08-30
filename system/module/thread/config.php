<?php
$config->thread->newDays = 3;

$config->thread->editor = new stdclass();
$config->thread->editor->post = array('id' => 'content', 'tools' => 'simpleTools');
$config->thread->editor->view = array('id' => 'content', 'tools' => 'simpleTools');
$config->thread->editor->edit = array('id' => 'content', 'tools' => 'simpleTools');

$config->thread->editor->allowTags = '<p><span><h1><h2><h3><h4><em><u><strong><br><ol><ul><li><img><a><b>';
