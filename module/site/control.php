<?php
/**
 * The control file of site module of xirangEPS.
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
            $result = $this->loadModel('setting')->setItems('system.common.site', $_POST);
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
            if(!empty($_FILES)) $this->send(array('result' => 'fail', 'message' => $this->lang->error->notSelectedLogo));

            $fileModel =  $this->loadModel('file');

            /*upload new logo*/
            $logo = $fileModel->saveUpload('logo');
            if(!$logo) $this->send(array('result'=>'fail', 'message'=>$this->lang->fail, inlink('setLogo')));

            $fileID   = array_keys($logo);
            $logoFile = $fileModel->getById($fileID[0]); 

            /*delete old logo*/
            $oldLogos  = $fileModel->getByObject('logo');
            foreach($oldLogos as $oldLogo)
            {
                if($oldLogo->id != $logoFile->id) $fileModel->delete($oldLogo->id);
            }
            
            /* save new logo data. */
            $setting  = new stdclass();

            $setting->fileID    = $logoFile->id;
            $setting->pathname  = $logoFile->pathname;
            $setting->webPath   = $logoFile->webPath;
            $setting->addedBy   = $logoFile->addedBy;
            $setting->addedDate = $logoFile->addedDate;

            $result = $this->loadModel('setting')->setItems('system.common.site', array('logo' => $json_encode($setting)) );
            if($result)
            {
                $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate'=>inlink('setLogo')));
            }
            else
            {
                $this->send(array('result'=>'fail', 'message'=>$this->lang->fail, inlink('setLogo')));
            }
        }
            
        $this->view->logo = isset($this->config->site->logo) ? json_decode($this->config->site->logo) : false;

        $this->display();
    }
}
