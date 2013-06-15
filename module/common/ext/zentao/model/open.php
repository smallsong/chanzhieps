<?php
public function printOpen($module, $article = '')
{
    echo ' > ' . html::a(inlink('index'), $module) . ' > ' . $article[0];
}
