<?php
/**
 * The index file of index/opt/rss module of XiRangEPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Congzhi Chen <congzhi@cnezsoft.com>
 * @author      Wenjie Song <wenjie@cnezsoft.com>
 * @package     index
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class index extends control
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($recTotal = 0, $recPerPage = 20, $pageID =  1)
    {
        $this->loadModel('article');
        $this->app->loadLang('user');

        if(!$recPerPage) $recPerPage = $this->config->article->indexCount;
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        /* Get articles. */
        $module   = 0;
        $orderBy  = 'id_desc';
        $articles = $this->loadModel('rssarticle')->getList($module, $orderBy, $pager);
        $this->article->createDigest($articles);
        foreach($articles as $article) $indexModules[] = $article->module;
        //$this->view->comments = $this->article->getCommentCounts(array_keys($articles));

        /* Assign the pager to view. */
        $this->view->header->title = $this->session->site->slogan;
        $this->view->layouts       = $this->loadModel('block')->getLayouts('index.index');
        $this->view->articleTree   = $this->loadModel('tree')->getTreeMenu('rss', 0, array('extTreeModel', 'createBrowseLink'));

        $this->view->modules       = $this->tree->getPairs($indexModules);
        $this->view->articles      = $articles;

        $this->view->pager = $pager;
        $this->display();
    }
}
