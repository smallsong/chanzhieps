<?php
public function createAdminLink($module)
{
    global $lang;
    $vars       = "moduleID=$module->id";
    $linkHtml   = html::a(helper::createLink('rssArticle', 'browseAdmin', $vars), $module->name, 'mainwin', "id='module{$module->id}'");
    $linkHtml  .= '[' . html::a(helper::createLink('rssFeed', 'browseAdmin', $vars), $lang->tree->feed, 'mainwin', "id='module{$module->id}'") . ']';
    return $linkHtml;
}

/**
 * Create the browse link.
 * 
 * @param string $module 
 * @access private
 * @return string
 */
public function createBrowseLink($module)
{
    $linkHtml = html::a(helper::createLink('rssArticle', 'browse', "moduleID={$module->id}"), $module->name, '', "id='module{$module->id}'");
    return $linkHtml;
}
