<?php
/**
 * The control file of menu module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     menu
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class menu extends control
{
    public function index($orderBy = 'menuOrder_desc')
    {   
        if($_POST)
        {
            $menus = $_POST['menu'];
            foreach($menus as $key => $data){
                $menus[$key] = $this->format($data);
            }
            if(isset($menus[2])) $menus[2] = $this->groupBy($menus[2], 'parent');
            if(isset($menus[3])) $menus[3] = $this->groupBy($menus[3], 'parent');
            a($menus);exit;
        }
        $this->view->menus = $this->config->site->menu;
        $this->display();
    }   

    public function format($data)
    {
        $count = count($data['title']); 
        $newData = array();
        for($i=0; $i<$count; $i++)
        {
            foreach($data as $key=>$values)  $newData[$i][$key] = $values[$i];
        }
        return $newData;
    }

    
    public function groupBy($list, $groupKey)
    {
        $newData = array();
        foreach($list as $row)
        {
            if(!isset($newData[$row[$groupKey]])) $newData[$row[$groupKey]] = array();
            $newData[$row[$groupKey]][] = $row;
        }
        return $newData;
    }
}
