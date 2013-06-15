<?php
/**
 * The control file of index module of XiRangBPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
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
        $indexModules = explode(',', $this->session->site->indexModules);
        foreach($indexModules as $moduleID)
        {
            $getFiles = false;
            $count    = 10;

            if(strpos($this->config->dehai->imageModules, ",$moduleID,") !== false)
            {
                $getFiles = true;
                $count    = 4;
            }
            $articles[$moduleID] = $this->article->getModuleArticle($moduleID, $getFiles, $count);
        }

        $this->view->header->title= $this->session->site->slogan;
        $this->view->layouts      = $this->loadModel('block')->getLayouts('index.index');
        $this->view->articleTree  = $this->loadModel('tree')->getTreeMenu('article', 0, array('treeModel', 'createBrowseLink'));
        $this->view->indexModules = $this->tree->getPairs($indexModules);
        $this->view->articles     = $articles;
        $this->display();
    }
}
