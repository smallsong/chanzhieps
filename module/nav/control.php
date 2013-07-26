<?php
/**
 * The control file of nav module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     nav
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class nav extends control
{
    /**
     * nav setting function
     *
     * @access public
     * @return void
     */
    public function index()
    {   
        if($_POST)
        {
            $navs = $_POST['nav'];
            foreach($navs as $key => $nav)
            {
                $navs[$key] = $this->nav->organizeNav($nav);
            }
            //a($navs);exit;
            if(isset($navs['2'])) $navs['2'] = $this->nav->group($navs['2']);
            if(isset($navs['3'])) $navs['3'] = $this->nav->group($navs['3']);
            $settings =  array('mainNav' => json_encode($navs));
            $result   = $this->loadModel('setting')->setItems('system.common.nav', $settings);
            if($result) $this->send(array('return' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->faild));
        }

        $this->view->navs = $navs = json_decode($this->config->nav->mainNav,true);
        $this->view->types = $this->lang->nav->types; 
        $this->view->articleTree  = $this->loadModel('tree')->getOptionMenu('article');

        if(empty($this->view->navs))
        {
            $defaultNav      = array();
            $defaultNav[1][] = array(
                'type' => 'common',
                'common' => 'home',
                'title' => $this->lang->home
            );
            $this->view->navs = $defaultNav;
        }
        $this->display();
    }   
}
