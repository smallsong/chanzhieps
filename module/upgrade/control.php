<?php
/**
 * The control file of upgrade module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class upgrade extends control
{
    /**
     * The index page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $return = $this->upgrade->canUpgrade();
        if($return['result'] == 'success') $this->locate(inlink('backup'));

        $this->view->title  = $this->lang->upgrade->index;
        $this->view->okFile = $return['okFile'];
        $this->display();
    }

    /**
     * The backup page.
     * 
     * @access public
     * @return void
     */
    public function backup()
    {
        $this->view->title = $this->lang->upgrade->backup;
        $this->view->db    = $this->config->db;
        $this->display();
    }

    /**
     * Select the version of old zentao.
     * 
     * @access public
     * @return void
     */
    public function selectVersion()
    {
        $version = str_replace(array(' ', '.'), array('', '_'), $this->config->installedVersion);
        $version = strtolower($version);

        $this->view->title   = $this->lang->upgrade->common . $this->lang->colon . $this->lang->upgrade->selectVersion;
        $this->view->version = $version;
        $this->display();
    }

    /**
     * Confirm the version.
     * 
     * @access public
     * @return void
     */
    public function confirm()
    {
        $this->view->title       = $this->lang->upgrade->confirm;
        $this->view->confirm     = $this->upgrade->getConfirm($this->post->fromVersion);
        $this->view->fromVersion = $this->post->fromVersion;

        $this->display();
    }

    /**
     * Execute the upgrading.
     * 
     * @access public
     * @return void
     */
    public function execute()
    {
        $this->upgrade->execute($this->post->fromVersion);

        $this->view->title = $this->lang->upgrade->result;

        if(!$this->upgrade->isError())
        {
            $this->view->result = 'success';
        }
        else
        {
            $this->view->result = 'fail';
            $this->view->errors = $this->upgrade->getError();
        }
        $this->display();
    }
}
