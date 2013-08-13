<?php
/**
 * The control file of company module of xirangEPS.
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
     * company profile.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->view->title    = $this->config->company->name;
        $this->view->keywords = $this->config->company->name;
        $this->view->company  = $this->config->company;
        $this->view->contact  = $this->company->getContact();

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
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }
        $this->display();
    }

    /**
     * set contact information.
     * 
     * @access public
     * @return void
     */
    public function setContact()
    {
        if(!empty($_POST))
        {
            $contact = array('contact' => json_encode($_POST));
            $result  = $this->loadModel('setting')->setItems('system.common.company', $contact);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }
        $this->view->contact = json_decode($this->config->company->contact);
        $this->display();
    }
}
