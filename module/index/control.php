<?php
/**
 * The control file of index module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     index
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class index extends control
{
    /**
     * Construct, must create this contruct function since there's index() also
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The index page of whole site.
     * 
     * @param int $recTotal     the total number of records
     * @param int $recPerPage   the number of records per page
     * @param int $pageID       current page id
     * @access public
     * @return void
     */
    public function index($recTotal = 0, $recPerPage = 0, $pageID = 1)
    {
        $this->loadModel('article');
        $this->app->loadLang('user');

        $this->view->slides = $this->loadModel('slide')->getList();
        $this->view->latestArticles = $this->loadModel('article')->getLatest(0,8);
        $this->view->contact        = json_decode($this->config->company->contact);
        $this->display();
    }
}
