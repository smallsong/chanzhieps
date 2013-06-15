<?php
/**
 * The control file of admin module of XiRangEPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     admin
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class admin extends control
{
    /**
     * The index page of admin panel, print the sites.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $sites = $this->loadModel('site')->getPairs();
        if(empty($sites))
        {
            echo js::alert('no site can admin.');
            die(js::locate($this->createLink('user', 'logout')));
        }
        $this->view->sites = $sites;
        $this->display();
    }

    /**
     * Manage a site.
     * 
     * @param  string $siteID 
     * @access public
     * @return array
     */
    public function site($siteID)
    { 
        $sites = $this->loadModel('site')->getPairs();

        if($siteID and isset($sites[$siteID]))
        {
            $site = $this->site->getById($siteID);
            $this->session->set('site', $site);
            $this->app->site = $site;
            $this->display();
        }
        else
        {
            $this->locate(inlink('index'));
        }
    }

    /**
     * The top menu frame.
     * 
     * @access public
     * @return void
     */
    public function topmenu()
    {
        $this->display();
    }

    /**
     * The left menu.
     * 
     * @param string $tree 
     * @access public
     * @return void
     */
    public function leftmenu($tree = 'article')
    {
        $this->view->tree     = $tree;
        $this->view->treeMenu = $this->loadModel('tree')->getTreeMenu($tree, $startModuleID = 0, array('treeModel', 'createAdminLink'));
        $this->display();
    }

    /**
     * Navigate for every. 
     * 
     * @access public
     * @return void
     */
    public function navigate()
    {
        $currentNav = current($this->config->admin->navigate);
        if($this->session->site->id != $currentNav['siteID'])
        {
            $sites = $this->loadModel('site')->getPairs();
            $site  = $this->site->getById($currentNav['siteID']);
            $this->session->set('site', $site);
            $this->app->site = $site;
        }
        $this->display();
    }

    /**
     * Left menu for navigate.
     * 
     * @access public
     * @return void
     */
    public function navLeftmenu()
    {
        $this->display();
    }

    /**
     * Goto url. 
     * 
     * @param  int    $siteID 
     * @param  string $url 
     * @access public
     * @return void
     */
    public function gotoUrl($siteID = 1, $url = '')
    {
        $sites = $this->loadModel('site')->getPairs();
        if($siteID and isset($sites[$siteID]) and $siteID != $this->session->site->id)
        {
            $site = $this->site->getById($siteID);
            $this->session->set('site', $site);
            $this->app->site = $site;
        }
        $this->locate(helper::safe64Decode($url));
    }
}
