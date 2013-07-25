<?php
/**
 * The model file of article category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Xiying Guan
 * @package     xirangEPS
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class menuModel extends model
{
    /**
     * create form input tags of backend.
     *
     * @param int $grade
     * @param array $menu
     *
     */
    public function createEntry($grade = 1, $menu = array())
    {
        $class         = "";
        $disabled      = '';
        $childGrade    = $grade+1;
        $articleTree   = $this->loadModel('tree')->getOptionMenu('article');
        $html .= '<i class="icon-folder-open shut"></i>';

        $type  = isset($menu['type']) ? $menu['type'] : ''; 
        $html .= html::select("menu[{$grade}][type][]", $this->lang->menu->types, $type, "class='menuType' grade='{$grade}'" );

        $hideArticle = $hideCommon = 'hide';
        if(isset($menu['type']) && $menu['type'] == 'article')
        {
            $hideArticle = "";
        }
        elseif($menu['type'] == 'common')
        {
            $hideCommon = "";
        }
        $html .= html::select("menu[{$grade}][article][]", $articleTree, $menu['article'], "class='menuSelector {$hideArticle}'");
        $html .= html::select("menu[{$grade}][common][]", $this->lang->menu->common, $menu['common'], "class='menuSelector {$hideCommon}'");

        $title = isset($menu['title']) ? $menu['title'] : "";
        $html .= html::input("menu[{$grade}][title][]", $title, "placeholder='{$this->lang->inputTitle}' class='input-small titleInput'");

        if(isset($menu['type']) && $menu['type'] != 'input')
        {
            $class    = "hide"; 
            $disabled = 'disabled';
        }
        $url   = isset($menu['url']) ? $menu['url'] : "";
        $html .= html::input("menu[{$grade}][url][]", $url, "placeholder='{$this->lang->inputUrl}' class='urlInput {$class}' {$disabled}");

        $html .= html::a('javascript:;', $this->lang->add, '', "class='plus{$grade}'" );
        if($childGrade < 4) $html .= html::a('javascript:;', $this->lang->addChild, '', "class='plus{$childGrade}'" );
        $html .= html::a('javascript:;', $this->lang->delete, '', 'class="remove red"' );
        $html .= '<i class="icon-arrow-up"></i> <i class="icon-arrow-down"></i>';
        if($grade >1 ) $html .= html::hidden("menu[{$grade}][parent][]", '', "class='grade{$grade}parent'" );
        $html .= html::hidden("menu[{$grade}][key][]", '', "class='input grade{$grade}key'"); 
        return $html;
    }

    /**
     * organize split menus to required structure.
     *
     * @param  array $menus         posted original menu .
     * @return array $organizeMenus   
     */
    public function organizeMenu($menus)
    {
        $menuCount = count($menus['title']); // get count by common item title.
        $organizedMenus = array();

        for($i = 0; $i < $menuCount; $i++)
        {
            foreach($menus as $field => $values) $formattedMenus[$i][$field] = $values[$i];
        }
        return $formattedMenus;
    }

    /**
     * group menu children by parent.
     *
     * @param  array $menus
     * @return array $menus
     */   
    public function group($menus)
    {
        $groupedMenus = array();
        foreach($menus as $menu)
        {
            if(!isset($groupedMenus[$menu['parent']])) $newData[$menu['parent']] = array();
            $groupedMenus[$menu['parent']][] = $menu;
        }
        return $groupedMenus;
    }
}
