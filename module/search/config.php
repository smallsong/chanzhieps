<?php
$config->search->xsRoot = '/usr/local/xunsearch';

$config->search->xsTables[TABLE_ARTICLE]   = "id as objectID, title, author, content, 'article' as objectType";
$config->search->xsTables[TABLE_ANSWER]    = "id as objectID, account as author, content, 'answer' as objectType";
$config->search->xsTables[TABLE_COMMENT]   = "id as objectID, author, content, 'comment' as objectType";
$config->search->xsTables[TABLE_EXTENSION] = "id as objectID, code as title, author, keyword as content, 'extension' as objectType";
$config->search->xsTables[TABLE_FAQ]       = "id as objectID, question as title, answer as content, 'faq' as objectType";
$config->search->xsTables[TABLE_GIFT]      = "id as objectID, name as title, account as author, `desc` as content, 'gift' as objectType";
$config->search->xsTables[TABLE_QUESTION]  = "id as objectID, title, account as author, `desc` as content, 'question' as objectType";
$config->search->xsTables[TABLE_REPLY]     = "id as objectID, author, content, 'reply' as objectType";
$config->search->xsTables[TABLE_THREAD]    = "id as objectID, site, title, author, content, 'thread' as objectType";
$config->search->xsTables[TABLE_USERCASE]  = "id as objectID, author, company as title, `desc` as content, 'usercase' as objectType";
$config->search->xsTables[TABLE_VIDEO]     = "id as objectID, author, name as title, `desc` as content, 'video' as objectType";
