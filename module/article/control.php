<?php
/**
 * The control file of article module of XiRangBPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class article extends control
{
    /**
     * The index page, locate to the browse page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $indexModules   = explode(',', $this->app->site->indexModules);
        $defaultModule = $indexModules[0];
        $this->locate(inlink('browse', "module=$defaultModule"));
    }

    /**
     * Browse article in front.
     * 
     * @param int $moduleID     the module id
     * @param string $orderBy   the order by
     * @param int $recTotal     record total
     * @param int $recPerPage   record per page
     * @param int $pageID       current page id
     * @access public
     * @return void
     */
    public function browse($moduleID = 0, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadLang('user');

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $childModules = $this->loadModel('tree')->getAllChildID($moduleID);
        $articles = $this->article->getList($childModules, $orderBy, $pager);
        $module   = $this->tree->getById($moduleID);

        if($this->session->site->type == 'blog')
        {
            $this->article->createDigest($articles);
            $this->view->comments = $this->article->getCommentCounts(array_keys($articles));
            $this->view->modules  = $this->tree->getPairs($childModules);
        }
        
        $this->view->header->title = $module->name;
        if($module)
        {
            $this->view->header->keywords = trim($module->keyword . ' ' . $this->app->site->keywords);
            if($module->desc) $this->view->header->desc = trim(preg_replace('/<[a-z\/]+.*>/Ui', '', $module->desc));
        }

        $this->view->module      = $module;
        $this->view->articles    = $articles;
        $this->view->pager       = $pager;
        $this->view->site        = $this->app->site;
        $this->view->layouts     = $this->loadModel('block')->getLayouts('article.list');
        $this->view->articleTree = $this->loadModel('tree')->getTreeMenu($this->view->module->tree, 0, array('treeModel', 'createBrowseLink'));

        $this->display();
    }

    /**
     * Browse article in admin.
     * 
     * @param string $tree      the article tree
     * @param int    $moduleID  the module id
     * @param string $orderBy   the order by
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function browseAdmin($tree = 'article', $moduleID = 0, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* Set the session. */
        $this->session->set('articleList', $this->app->getURI(true));

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $childModules = $this->loadModel('tree')->getAllChildID($moduleID, $tree);
        $articles = $childModules ? $this->article->getList($childModules, $orderBy, $pager) : array();

        $this->view->articles = $articles;
        $this->view->pager    = $pager;
        $this->view->module   = $this->tree->getById($moduleID);
        $this->view->tree     = $tree;

        $this->display();
    }

    /**
     * Create a article.
     * 
     * @param mixed $moduleID   the module or the tree
     * @param string $tree 
     * @access public
     * @return void
     */
    public function create($moduleID = 0)
    {
        /* Set the mdoule and tree.  */
        if(is_numeric($moduleID)) 
        {
            $module = $this->loadModel('tree')->getById($moduleID); 
            $tree   = $module->tree;
        }
        else
        {
            $module   = null;
            $tree     = $moduleID;
            $moduleID = 0;
        }

        if($_POST)
        {
            $this->article->create();
            if(dao::isError()) die(js::error(dao::getError()));
            $orderBy = $tree == 'article' ? 'id_desc' : '`order`';
            die(js::locate(inlink('browseAdmin', "tree=$tree&module=$moduleID&orderBy=$orderBy"), 'parent'));
        }

        $this->view->module    = $module;
        $this->view->tree      = $this->loadModel('tree')->getOptionMenu($tree);
        $this->view->siteTrees = $this->loadModel('site')->getLinkSitesOptionMenu($this->app->site->linkSites, $tree);
        $this->view->type      = $tree == 'article' ? 'article' : 'doc';
        $this->display();
    }

    /**
     * Edit a article.
     * 
     * @param string $articleID 
     * @param string $tree 
     * @access public
     * @return void
     */
    public function edit($articleID)
    {
        $this->view->article= $this->article->getById($articleID);
        if($_POST)
        {
            $this->article->update($articleID);
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate($this->session->articleList, 'parent'));
        }

        $this->view->module      = $this->loadModel('tree')->getById($this->view->article->module);
        $this->view->tree        = $this->loadModel('tree')->getOptionMenu($this->view->article->tree);
        $this->view->siteTrees   = $this->loadModel('site')->getLinkSitesOptionMenu($this->session->site->linkSites, $this->view->article->tree);
        $this->display();
    }

    /**
     * Update order fields.
     * 
     * @access public
     * @return void
     */
    public function updateOrder()
    {
        if($this->post->orders)
        {
            foreach($this->post->orders as $articleID => $order)
            {
                $this->dao->update(TABLE_ARTICLE)
                    ->set('`order`')->eq($order)
                    ->where('id')->eq($articleID)
                    ->limit(1)
                    ->exec(false);
            }
            die(js::reload('parent'));
        }
    }

    /**
     * View an article.
     * 
     * @param string $articleID 
     * @access public
     * @return void
     */
    public function view($articleID)
    {
        $article = $this->article->getById($articleID);
        if(RUN_MODE == 'front')
        { 
            $this->view->layouts          = $this->loadModel('block')->getLayouts('article.view');
            $this->view->articleTree      = $this->loadModel('tree')->getTreeMenu('article', 0, array('treeModel', 'createBrowseLink'));
            $this->view->module           = $this->tree->getById($article->module);

            $this->view->header->title    = $article->title . (isset($this->view->module->name) ? '|' . $this->view->module->name : '');
            $this->view->header->keywords = trim($article->keywords . ' ' . $this->view->module->keyword . ' ' . $this->app->site->keywords);
            $this->view->header->desc     = trim($article->summary . ' ' .preg_replace('/<[a-z\/]+.*>/Ui', '', $this->view->module->desc));

            $this->dao->update(TABLE_ARTICLE)->set('views = views + 1')->where('id')->eq($articleID)->exec(false);
        }
        $this->view->article = $article;

        $this->display();
    }

    /**
     * Delete a article
     * 
     * @param string $articleID 
     * @param string $confirm 
     * @access public
     * @return void
     */
    public function delete($articleID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->article->confirmDelete, inlink('delete', "articleID=$articleID&confirm=yes"));
            exit;
        }
        else
        {
            $this->article->delete($articleID);
            die(js::reload('parent'));
        }
    }
}
