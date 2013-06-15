<?php
/**
 * Create link for extension browse.
 * 
 * @param  object    $module 
 * @access public
 * @return string
 */
public function createBrowseAppLink($module)
{
    $linkHtml = html::a(helper::createLink('webapp', 'browse', "type=byModule&param={$module->id}", 'html'), $module->name, '', "id='module{$module->id}'");
    return $linkHtml;
}

public function createAppApiLink($module)
{
    $linkHtml = html::a(helper::createLink('webapp', 'obtain', "type=byModule&moduleID=" . helper::safe64Encode($module->id), 'html'), $module->name, '', "id='module{$module->id}'");
    return $linkHtml;
}
