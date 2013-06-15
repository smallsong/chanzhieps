<?php
public function printHelp($book, $article = '', $misc = '')
{
    if(isset($book['book']) and $book['book']) echo ' > ' . html::a(inlink('book', "book=".$book['book']->id), $book['book']->name);
    if(!empty($book['module']))
    {
        foreach($book['module']->pathNames as $moduleID => $moduleName) echo ' > ' . html::a(inlink('book', "book=".$book['book']->id."&moduleID=$moduleID"), $moduleName);
    }
    if($article) echo ' > ' . $article->title;
    if($misc)    echo ' > ' . $misc;
}
