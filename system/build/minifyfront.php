<?php
/**
* This file is used to compress css and js files.
*/

$baseDir = dirname(dirname(dirname(__FILE__)));

//--------------------------------- PROCESS JS FILES ------------------------------ //

/* Set jsRoot and jqueryRoot. */
$jsRoot     = $baseDir . '/www/js/';
$jqueryRoot = $jsRoot . 'jquery/';

/* Set js files to combined. */
$jsFiles[] = $jsRoot . 'jquery/min.js';
$jsFiles[] = $jsRoot . 'jquery/form/min.js';
$jsFiles[] = $jsRoot . 'bootstrap/min.js';
$jsFiles[] = $jsRoot . 'chanzhi.js';
$jsFiles[] = $jsRoot . 'my.js';

/* Combine these js files. */
$allJSFile  = $jsRoot . 'all.js';
$jsCode = '';
foreach($jsFiles as $jsFile) $jsCode .= "\n". file_get_contents($jsFile);
$result = file_put_contents($allJSFile, $jsCode);
if($result)
{
    echo "压缩js成功！\n";
}

/* Compress it. */
`java -jar ~/bin/yuicompressor/build/yuicompressor.jar --type js $allJSFile -o $allJSFile`;

//-------------------------------- PROCESS CSS FILES ------------------------------ //

/* Define the themeRoot. */
$themeRoot  = $baseDir . '/www/theme/';

/* Common css files. */
$cssCode  = str_replace('../img', '../bootstrap/img', file_get_contents($themeRoot . 'bootstrap/css/core.min.css'));
$cssCode  = str_replace('../font', '../bootstrap/font', $cssCode);
$cssCode .= file_get_contents($themeRoot . 'default/style.css');

/* Combine them. */
$cssFile = $themeRoot . "default/all.css";
$result  = file_put_contents($cssFile, $cssCode);
if($result)
{
    echo "压缩CSS成功！\n";
}


/* Compress it. */
`java -jar ~/bin/yuicompressor/build/yuicompressor.jar --type css $cssFile -o $cssFile`;
