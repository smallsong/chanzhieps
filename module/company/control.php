<?php
/**
 * The control file of company module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     company
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class company extends control
{
    /**
     * company profile about us.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->config->site->menuLinks = array();
        $this->app->site->menuLinks[] = $this->lang->aboutUs;
        $this->view->company = $this->config->company;
        $this->display();
    }

    /**
     * set company basic info.
     * 
     * @access public
     * @return void
     */
    public function setBasic()
    {
        if(!empty($_POST))
        {
            $result = $this->loadModel('setting')->setItems('system.common.company', (object)$_POST);
            if($result) $this->send(array('return' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->faild));
        }
        $this->display();
    }

   /**
     * set company basic info.
     * 
     * @access public
     * @return void
     */
    public function setContact()
    {
        if(!empty($_POST))
        {
            $contact = array('contact' => json_encode($_POST));
            $result = $this->loadModel('setting')->setItems('system.common.company', $contact);
            if($result) $this->send(array('return' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->faild));
        }
        $this->view->contact = json_decode($this->config->company->contact);
        $this->display();
    }

}
