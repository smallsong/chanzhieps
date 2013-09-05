<?php
/**
 * The control file of blog category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class blog extends control
{
    /** 
     * Browse blog in front.
     * 
     * @param int    $categoryID   the category id
     * @param string $orderBy      the order by
     * @param int    $recTotal     record total
     * @param int    $recPerPage   record per page
     * @param int    $pageID       current page id
     * @access public
     * @return void
     */
    public function index($categoryID = 0, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $category = $this->loadModel('tree')->getById($categoryID);
        $articles = $this->loadMOdel('article')->getList($this->tree->getFamily($categoryID, 'blog'), $orderBy, $pager);

        if($category)
        {
            $title    = $category->name;
            $keywords = trim($category->keyword . ' ' . $this->config->site->keywords);
            $desc     = strip_tags($category->desc);
        }

        $this->view->title     = $title;
        $this->view->keywords  = $keywords;
        $this->view->desc      = $desc;
        $this->view->category  = $category;
        $this->view->articles  = $articles;
        $this->view->pager     = $pager;
        $this->view->contact   = $this->loadModel('company')->getContact();
        //$this->view->layouts = $this->loadModel('block')->getLayouts('article.list');

        $this->display();
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
        $article  = $this->loadModel('article')->getById($articleID);

        /* fetch first category for display. */
        $category = array_slice($article->categories, 0, 1);
        $category = $category[0];
        $category = $this->loadModel('tree')->getById($category->id);

        $title    = $article->title . ' - ' . $category->name;
        $keywords = $article->keywords . ' ' . $category->keyword . ' ' . $this->config->site->keywords;
        $desc     = strip_tags($article->summary);
        
        $this->view->title      = $title;
        $this->view->keywords   = $keywords;
        $this->view->desc       = $desc;
        $this->view->article    = $article;
        $this->view->category   = $category;
        $this->view->contact    = $this->loadModel('company')->getContact();

        $this->dao->update(TABLE_ARTICLE)->set('views = views + 1')->where('id')->eq($articleID)->exec(false);
        $this->display();
    }
}
