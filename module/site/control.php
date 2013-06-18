<?php
/**
 * The control file of site module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class site extends control
{
    /**
     * Index page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate($this->createLink('site', 'browse'));
    }

    /**
     * Create a site.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        if(!empty($_POST))
        {
            $this->site->create();
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate($this->createLink('admin'), 'parent.parent'));
        }

        $this->view->sites = $this->site->getPairs();
        $this->display();
    }

    /**
     * Edit a site.
     * 
     * @param  string $siteID 
     * @access public
     * @return void
     */
    public function edit($siteID)
    {
        if(!empty($_POST))
        {
            $this->site->update($siteID);
            if(dao::isError()) die(js::error(dao::getError()));
            echo js::alert($this->lang->site->successSaved);
            die(js::locate($this->createLink('admin'), 'parent.parent'));
        }

        $this->view->site  = $this->site->getById($siteID);
        $this->view->sites = $this->site->getPairs();
        unset($this->view->sites[$siteID]);
        $this->display();
    }

    /**
     * Delete a site.
     * 
     * @param  string $siteID 
     * @param  string $confirm 
     * @access public
     * @return void
     */
    public function delete($siteID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->site->confirmDelete, $this->createLink('site', 'delete', "siteID=$siteID&confirm=yes"));
            exit;
        }
        else
        {
            $this->site->delete($siteID);
            die(js::locate($this->createLink('admin', 'index'), 'top'));
        }
    }

    /**
     * Set a site.
     * 
     * @access public
     * @return void
     */
    public function set()
    {
        if(!empty($_POST))
        {
            $this->site->saveSetting();
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::alert($this->lang->site->successSaved));
        }

        $site       = $this->site->getById($this->session->site->id);
        $optionMenu = $this->loadModel('tree')->getOptionMenu('article');

        /* Process the modules show in index page. */
        $indexModules  = explode(',', $site->indexModules);
        foreach($indexModules as $key => $catID)
        {
            unset($indexModules[$key]);
            if(!isset($optionMenu[$catID])) continue;
            $indexModules[$catID] = $optionMenu[$catID];
        }
        if(!$indexModules) $indexModules = array('' => '');
        $this->view->site         = $site;
        $this->view->optionMenu   = $optionMenu;
        $this->view->indexModules = $indexModules;
        $this->display();
    }
}
