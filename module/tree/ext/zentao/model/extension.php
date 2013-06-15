<?php
/**
 * Create link for extension API.
 * 
 * @param  object $module 
 * @param  string $requestLang 
 * @access private
 * @return string
 */
public function createApiLink($module, $requestLang)
{
    $names = explode('|', $module->name);
    $zh = $names[0];
    if(isset($names[1])) $en = $names[1];
    if($requestLang == 'zh_cn')
    {
        $module->name = $zh;
    }
    elseif($requestLang == 'zh_tw')
    {
        global $app;
        $cconv = $app->loadClass('cconv');
        $module->name = $cconv->changeCode($zh,'big5');
    }
    elseif($requestLang == 'en')
    {
        if(!empty($en)) $module->name = $en;
        else $module->name = $zh;
    }
    $linkHtml = html::a(helper::createLink('extension', 'obtain', "type=byModule&moduleID=" . helper::safe64Encode($module->id) . "&requestLang=$requestLang", 'html'), $module->name, '', "id='module{$module->id}'");
    return $linkHtml;
}

/**
 * Create link for zh-cn.
 * 
 * @param  object    $module 
 * @access public
 * @return string
 */
public function createZH_CN($module)
{
    return self::createApiLink($module, 'zh_cn');
}

/**
 * Create link for zh-tw.
 * 
 * @param  object    $module 
 * @access public
 * @return string
 */
public function createZH_TW($module)
{
    return self::createApiLink($module, 'zh_tw');
}

/**
 * Create link for english. 
 * 
 * @param  object    $module 
 * @access public
 * @return string
 */
public function createEN($module)
{
    return self::createApiLink($module, 'en');
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
    $requestLang = $_COOKIE['lang'];

    $names = explode('|', $module->name);
    $zh = $names[0];
    if(isset($names[1])) $en = $names[1];
    if(empty($requestLang) or $requestLang == 'zh-cn')
    {
        $module->name = $zh;
    }
    elseif($requestLang == 'zh-tw')
    {
        global $app;
        $cconv = $app->loadClass('cconv');
        $module->name = $cconv->changeCode($zh,'big5');
    }
    elseif($requestLang == 'en')
    {
        if(!empty($en)) $module->name = $en;
        else $module->name = $zh;
    }
    $linkHtml = html::a(helper::createLink('extension', 'browse', "type=byModule&moduleID={$module->id}", 'html'), $module->name, '', "id='module{$module->id}'");
    return $linkHtml;
}
