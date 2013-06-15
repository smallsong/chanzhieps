<?php
/**
 * Create link for extension API.
 * 
 * @param  object $module 
 * @access public
 * @return string
 */
public function createApiLink($module)
{
    $linkHtml = html::a(helper::createLink('extension', 'obtain', "type=byModule&moduleID=" . helper::safe64Encode($module->id), 'html'), $module->name, '', "id='module{$module->id}'");
    return $linkHtml;
}

/**
 * Create link for extension browse.
 * 
 * @param  object    $module 
 * @access public
 * @return string
 */
public function createBrowseLink($module)
{
    $linkHtml = html::a(helper::createLink('extension', 'browse', "type=byModule&moduleID={$module->id}", 'html'), $module->name, '', "id='module{$module->id}'");
    return $linkHtml;
}
