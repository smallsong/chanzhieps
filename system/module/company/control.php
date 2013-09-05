<?php
/**
 * The control file of company module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     company
 * @version     $Id$
 * @link        http://www.chanzhi.org
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
            $contact = array('contact' => helper::jsonEncode($_POST));
            $result  = $this->loadModel('setting')->setItems('system.common.company', $contact);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }
        $this->view->contact = json_decode($this->config->company->contact);
        $this->display();
    }
}
