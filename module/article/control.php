<?php
/**
 * The control file of article category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
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
        $indexCategories = explode(',', $this->config->site->indexCategories);
        $defaultCategory = $indexCategories[0];
        $this->locate(inlink('browse', "category=$defaultCategory"));
    }   

    /** 
     * Browse article in front.
     * 
     * @param int    $categoryID   the category id
     * @param string $orderBy      the order by
     * @param int    $recTotal     record total
     * @param int    $recPerPage   record per page
     * @param int    $pageID       current page id
     * @access public
     * @return void
     */
    public function browse($categoryID = 0, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->app->loadLang('user');
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $category = $this->loadModel('tree')->getById($categoryID);
        $articles = $this->article->getList($this->tree->getFamily($categoryID), $orderBy, $pager);

        if($category)
        {
            $this->view->keywords = trim($category->keyword . ' ' . $this->config->site->keywords);
            if($category->desc) $this->view->desc = strip_tags($category->desc);
        }

        $this->view->title = $category->name;
        $this->view->category      = $category;
        $this->view->articles      = $articles;
        $this->view->pager         = $pager;
        $this->view->site          = $this->config->site;
        //$this->view->layouts     = $this->loadModel('block')->getLayouts('article.list');
        $this->view->articleTree   = $this->loadModel('tree')->getTreeMenu($this->view->category->tree, 0, array('treeModel', 'createBrowseLink'));

        $this->display();
    }

    /**
     * Browse article in admin.
     * 
     * @param string $type        the article type
     * @param int    $categoryID  the category id
     * @param string $orderBy     the order by
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function admin($type = 'article', $categoryID = 0, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        /* Set the session. */
        $this->session->set('articleList', $this->app->getURI(true));

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $families = $this->loadModel('tree')->getFamily($categoryID, $type);
        $articles = $families ? $this->article->getList($families, $orderBy, $pager) : array();

        $this->view->title    = $this->lang->article->admin;
        $this->view->articles = $articles;
        $this->view->pager    = $pager;
        $this->view->category = $this->tree->getById($categoryID);
        $this->view->type     = $type;

        $this->display();
    }   

    /**
     * Create a article.
     * 
     * @param  string $type 
     * @param  int    $categoryID
     * @access public
     * @return void
     */
    public function create($type = 'article', $categoryID = '')
    {
        if($_POST)
        {
            $this->article->create();       
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::geterror()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate'=>inlink('admin')));
        }

        $categories =  $this->loadModel('tree')->getOptionMenu($type);
        unset($categories[0]);

        $this->view->title           = $this->lang->article->create;
        $this->view->currentCategory = $categoryID;
        $this->view->categories      = $categories;
        $this->view->type            = $type;

        $this->display();
    }

    /**
     * Edit an article.
     * 
     * @param  int $articleID 
     * @access public
     * @return void
     */
    public function edit($articleID)
    {
        if($_POST)
        {
            $this->article->update($articleID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin')));
        }
        $article    = $this->article->getByID($articleID);
        $categories =  $this->loadModel('tree')->getOptionMenu($article->type);
        unset($categories[0]);

        $this->view->title      = $this->lang->article->edit;
        $this->view->article    = $article;
        $this->view->categories = $categories;

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
     * @param int $articleID 
     * @access public
     * @return void
     */
    public function view($articleID)
    {
        $article = $this->article->getById($articleID);

        $this->view->articleTree = $this->loadModel('tree')->getTreeMenu('article', 0, array('treeModel', 'createBrowseLink'));
        $this->view->category    = $this->tree->getById($article->category);
        $this->view->title    = $article->title . (isset($this->view->category->name) ? '|' . $this->view->category->name : '');
        $this->view->keywords = trim($article->keywords . ' ' . $this->view->category->keyword . ' ' . $this->config->site->keywords);
        $this->view->desc     = trim($article->summary . ' ' .preg_replace('/<[a-z\/]+.*>/Ui', '', $this->view->category->desc));
        //$this->view->layouts          = $this->loadModel('block')->getLayouts('article.view');

        $this->dao->update(TABLE_ARTICLE)->set('views = views + 1')->where('id')->eq($articleID)->exec(false);
        $this->view->article = $article;

        $this->display();
    }

    /**
     * Delete an article.
     * 
     * @param  int      $articleID 
     * @access public
     * @return void
     */
    public function delete($articleID)
    {
        $result = $this->article->delete($articleID);

        if($result) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
}
