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
     * nav admin function
     *
     * @access public
     * @return void
     */
    public function admin()
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
            
            foreach($navs[2] as &$navList)
            {
                foreach($navList as &$nav)
                $nav['children'] = isset($navs[3][$nav['key']]) ?  $navs[3][$nav['key']] : array();
            }
            foreach($navs[1] as &$nav)
            {
                $nav['children'] = isset($navs[2][$nav['key']]) ?  $navs[2][$nav['key']] : array();
            }

            $settings =  array('topNav' => json_encode($navs[1]));
            $result   = $this->loadModel('setting')->setItems('system.common.nav', $settings);
            if($result) $this->send(array('return' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->faild));
        }

        $this->view->navs = json_decode($this->config->nav->mainNav,true);

        $this->view->types = $this->lang->nav->types; 
        $this->view->articleTree  = $this->loadModel('tree')->getOptionMenu('article');

        if(empty($this->view->navs))
        {
            $originNav = array();
            $originNav['type']   =  'common';
            $originNav['common'] =  'home';
            $originNav['title']  = $this->lang->home;

            $this->view->navs = array(1 => array($originNav));
        }

        $this->display();
    }   
}
