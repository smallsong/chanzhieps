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
    public function setBasic()
    {
        if(!empty($_POST))
        {
            $result = $this->loadModel('setting')->setItems('system.common.site', (object)$_POST);
            if($result) $this->send(array('return' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->faild));
        }
        $this->display();
    }
    /**
     * set logo.
     * 
     * @access public
     * @return void
     */
    public function setLogo()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if(!empty($_FILES))
            {
                $fileModel =  $this->loadModel('file');

                /*delete old logo*/
                $oldLogos  = $fileModel->getByObject('logo');
                foreach($oldLogos as $file)
                {
                    $fileModel->delete($file->id);
                }

                /*upload new logo*/
                $logo     = $fileModel->saveUpload('logo');
                $fileID   = array_keys($logo);
                $file     = $fileModel->getById($fileID[0]); 

                $setting  = new stdclass();
                $setting->fileID    = $file->id;
                $setting->pathname  = $file->pathname;
                $setting->webPath   = $file->webPath;
                $setting->addedBy   = $file->addedBy;
                $setting->addedDate = $file->addedDate;

                $config = array();
                $config['logo'] = json_encode($setting);
                $result = $this->loadModel('setting')->setItems('system.common.site', $config);
                if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate'=>inlink('setLogo')));
                $this->send(array('result'=>'fail', 'message'=>$this->lang->fail, inlink('setLogo')));
            }
            else
            {
                $this->send(array('result' => 'fail', 'message' => $this->lang->error->notSelectedLogo));
            }
        }
        if(isset($this->config->site->logo)) $this->view->logo = json_decode($this->config->site->logo);
        $this->display();
    }

   /**
     * add menu.
     * 
     * @access public
     * @return void
     */
    public function addMenu()
    {
        if(!empty($_POST))
        {
            $menu = array('menu' => json_encode($_POST));
            $result = $this->loadModel('setting')->setItems('system.common.site', $menu);
            if($result) $this->send(array('return' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }
        $this->display();
    }

    public function menubrowse($orderBy = 'menuOrder_desc')
    {   
        $this->view->menus = $this->config->site->menu;
        $this->display();
    }   
}
