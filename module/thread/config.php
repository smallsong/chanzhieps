<?php
$config->thread->newDays      = 3;
$config->thread->maxImgSize   = 750;
$config->thread->editor = new stdClass();
$config->thread->editor->post = array('id' => 'content', 'tools' => 'simpleTools');
$config->thread->editor->view = array('id' => 'content', 'tools' => 'simpleTools');
$config->thread->editor->editthread = array('id' => 'content', 'tools' => 'simpleTools');
$config->thread->editor->editreply  = array('id' => 'content', 'tools' => 'simpleTools');
$config->thread->editor->allowableTags = '<p><span><h1><h2><h3><h4><em><u><strong><br><ol><ul><li><img><a><b>';

$config->thread->writeBoard = ',1298,1299,';

$config->thread->blacklist['ip']      = array();
$config->thread->blacklist['keyword'] = array();

$config->thread->blacklist['keyword'][] = 'dudool.com';

$config->thread->blacklist['phone'][] = '06642271480';
$config->thread->blacklist['phone'][] = '00760910080';
$config->thread->blacklist['phone'][] = '00889868282';
$config->thread->blacklist['phone'][] = '01-202-320';
$config->thread->blacklist['phone'][] = '01-202-328 2516';
$config->thread->blacklist['phone'][] = '01-732-7958856';
$config->thread->blacklist['phone'][] = '01-810-4700';
$config->thread->blacklist['phone'][] = '01-936-9367';
$config->thread->blacklist['phone'][] = '0800-810-4700';
$config->thread->blacklist['phone'][] = '0800-912-1275';

$config->thread->blacklist['company'][] = 'apple';
$config->thread->blacklist['company'][] = 'AT&T';
$config->thread->blacklist['company'][] = 'microsoft';

$config->thread->blacklist['ip'][] = '222.186.27.97';
$config->thread->blacklist['ip'][] = '198.50.161.2';
$config->thread->blacklist['ip'][] = '198.50.161.16';
$config->thread->blacklist['ip'][] = '198.50.161.6';
$config->thread->blacklist['ip'][] = '60.169.73.186';
$config->thread->blacklist['ip'][] = '198.50.161.30';
$config->thread->blacklist['ip'][] = '198.50.161.21';
$config->thread->blacklist['ip'][] = '60.169.78.57';
$config->thread->blacklist['ip'][] = '199.193.64.5';
$config->thread->blacklist['ip'][] = '198.50.161.26';
$config->thread->blacklist['ip'][] = '61.160.213.53';
$config->thread->blacklist['ip'][] = '60.169.80.42';
$config->thread->blacklist['ip'][] = '61.160.195.141';
$config->thread->blacklist['ip'][] = '61.160.232.204';
$config->thread->blacklist['ip'][] = '222.184.24.147';
$config->thread->blacklist['ip'][] = '198.50.161.19';
$config->thread->blacklist['ip'][] = '198.50.161.11';
$config->thread->blacklist['ip'][] = '222.186.24.68';
$config->thread->blacklist['ip'][] = '198.245.63.108';
$config->thread->blacklist['ip'][] = '60.169.78.177';
$config->thread->blacklist['ip'][] = '222.186.25.126';
$config->thread->blacklist['ip'][] = '198.50.161.17';
$config->thread->blacklist['ip'][] = '182.84.98.44';
$config->thread->blacklist['ip'][] = '198.50.161.14';
$config->thread->blacklist['ip'][] = '61.160.212.184';
$config->thread->blacklist['ip'][] = '198.50.161.3';
$config->thread->blacklist['ip'][] = '198.50.161.7';
$config->thread->blacklist['ip'][] = '198.50.161.23';
$config->thread->blacklist['ip'][] = '69.64.42.27';
$config->thread->blacklist['ip'][] = '198.50.161.13';
$config->thread->blacklist['ip'][] = '222.186.25.105';
$config->thread->blacklist['ip'][] = '198.50.161.4';
$config->thread->blacklist['ip'][] = '198.50.161.1';
$config->thread->blacklist['ip'][] = '198.50.161.18';
$config->thread->blacklist['ip'][] = '198.50.161.20';
$config->thread->blacklist['ip'][] = '198.50.161.25';
$config->thread->blacklist['ip'][] = '198.50.161.8';
$config->thread->blacklist['ip'][] = '60.169.78.172';
$config->thread->blacklist['ip'][] = '222.186.26.46';
$config->thread->blacklist['ip'][] = '198.50.161.0';
$config->thread->blacklist['ip'][] = '60.169.77.2';
