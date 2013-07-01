<?php
/**
 * The control file of site module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class site extends control
{
    /**
     * set site basic info.
     * 
     * @access public
     * @return void
     */
    public function setbasic()
    {
        if(!empty($_POST))
        {
            $settings = new stdclass();
            $settings->global = new stdclass();

            $settings->global->name   = $this->post->name;
            $settings->global->slogan = $this->post->slogan;
            $settings->global->desc   = $this->post->desc;

            $re = $this->site->saveSetting($settings);
            if($re) $this->send(array('return'=>'success', 'message'=>'保存成功'  ,'loacte'=>inlink('setbasic')));
        }
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

}
