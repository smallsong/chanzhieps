<?php
public function printVideo($video, $article = '')
{
    if($video['video']) echo ' > ' . html::a(inlink('browse'), $video['video']['name']);
    if(!empty($video['module']))
    {
         echo ' > ' . html::a(inlink('browseModule', 'id=' . $video['module']->id), $video['module']->name);
    }
    if($article) echo ' > ' . $article->name;
}
