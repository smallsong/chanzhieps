<?php
/**
 * The model file of article category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     xirangEPS
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class menuModel extends model
{
    public function inputTags($grade = 1, $menu = array())
    {
        $childGrade = $grade+1;
        $html  =  ''; 
        $html .= '<i class="icon-folder-open shut"></i>';
        $html .= html::select("menu[{$grade}][menuType][]", $this->lang->menu->types, isset($menu['menuType']) ? $menu['menuType'] : '', " class='menuType' grade='{$grade}'" );

        $html .= html::input("menu[{$grade}][title][]",  isset($menu['title']) ? $menu['title'] : "", 'placeholder="' . $this->lang->inputTitle . '" class="input-small titleInput"');
        if(isset($menu['type']) && $menu['type'] != 'input')
        {
            $class    = "hide"; 
            $disabled = 'disabled';
        }
        else
        {
            $class = "";
            $disabled = '';
        }
        $html .= html::input("menu[{$grade}][url][]",    isset($menu['url']) ? $menu['url'] : "",  "placeholder='{$this->lang->inputUrl}' class='urlInput {$class}' {$disabled}");
        $html .= html::hidden("menu[{$grade}][g{$grade}key][]", '', "class='input grade{$grade}key'"); 
        if($grade >1 ) $html .= html::hidden("menu[{$grade}][parent][]", '', "class='grade{$grade}parent'" );
        $html .= html::a('javascript:;', $this->lang->add, '', "class='plus{$grade}'" );
        if($childGrade < 4) $html .= html::a('javascript:;', $this->lang->addChild, '', "class='plus{$childGrade}'" );
        $html .= html::a('javascript:;', $this->lang->delete, '', 'class="remove"' );
        $html .= '<i class="icon-arrow-up"></i> <i class="icon-arrow-down"></i>';
        return $html;
    }

    public function isCurrent($menu)
    {
        
    }

    public function getUri()
    {
        
    }

    public function articleSelector($grade, $menu)
    {
        $tree = $this->loadModel('tree')->getOptionMenu('article');
        return html::select("menu[{$grade}][article][]", $tree, isset($menu['article']) ? $menu['article']: 0, "class='menuSelector articleSelector'");
    }

    public function commonMenuSelector($grade, $menu)
    {
        return html::select("menu[{$grade}][common][]", $this->lang->menu->common, isset($menu['common']) ? $menu['common']: 0, "class='menuSelector commonSelector'");
    }
}
