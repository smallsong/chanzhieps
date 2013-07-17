<?php
/**
 * The model file of article category of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class articleModel extends model
{
    /** 
     * Get article info by id.
     * 
     * @param  int $articleId 
     * @param  int $imgMaxWidth 
     * @access public
     * @return void
     */
    public function getById($articleId, $imgMaxWidth = 0)
    {   
        $article = $this->dao->select('*')
            ->from(TABLE_ARTICLE)->alias('t1')
            ->leftJoin(TABLE_ARTICLECATEGORY)->alias('t2')->on('t1.id = t2.article')
            ->where('t1.id')->eq($articleId)
            ->fetch();

        $article->files   = $this->loadModel('file')->getByObject('article', $articleId);
        foreach($article->files as $file) if($file->isImage and $file->public) $article->images[] = $file;
        return $article;
    }   

    /** 
     * Get article list.
     * 
     * @param string $categories 
     * @param string $orderBy 
     * @param string $pager 
     * @access public
     * @return array
     */
    public function getList($categories, $orderBy, $pager = null)
    {
        $articles = $this->dao->select('t1.*, t2.category')->from(TABLE_ARTICLE)->alias('t1')
            ->leftJoin(TABLE_ARTICLECATEGORY)->alias('t2')->on('t1.id = t2.article')
            ->where('1 = 1')
            ->beginIF($categories)->andWhere('t2.category')->in($categories)->fi()
            ->groupBy('t2.article')
            ->page($pager)
            ->fetchAll('id');
        $categories = $this->dao->select('*')->from(TABLE_ARTICLECATEGORY)
            ->where('1 = 1')
            ->beginIF($categories)->andWhere('category')->in($categories)->fi()
            ->fetchGroup('article');

        foreach($articles as $articleID => &$article)
        {   
            $article->categories = $categories[$articleID];
        }
        return $articles;
    }

    /**
     * Get article pairs.
     * 
     * @param string $categories 
     * @param string $orderBy 
     * @param string $pager 
     * @access public
     * @return array
     */
    public function getPairs($categories, $orderBy, $pager = null)
    {
        return $this->dao->select('id, title')->from(TABLE_ARTICLE)->alias('t1')
            ->leftJoin(TABLE_ARTICLECATEGORY)->alias('t2')
            ->on('t1.id = t2.article')
            ->beginIF($categories)->andWhere('t2.category')->in($categories)->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchPairs('id', 'title');
    }

    /**
     * Get articles of an category.
     * 
     * @param string $categoryID  the category id
     * @param string $getFiles  get it's files or not
     * @param int $count 
     * @access public
     * @return array
     */
    public function getCategoryArticle($categoryID, $getFiles = false, $count = 10)
    {
        $this->loadModel('tree');
        $childs = $this->tree->getAllChildId($categoryID);
        $articles = $this->dao->select('id, title, author, addedDate, summary')
            ->from(TABLE_ARTICLE)->alias('t1')
            ->leftJoin(TABLE_ARTICLECATEGORY)->alias('t2')
            ->on('t1.id = t2.article')
            ->where('t2.site')->eq($this->app->site->id)
            ->andWhere('category')->in($childs)
            ->orderBy('id desc')->limit($count)->fetchAll('id');
        if(!$getFiles) return $articles;

        /* Fetch files. */
        $files = $this->loadModel('file')->getByObject('article', array_keys($articles));
        foreach($files as $file) $articles[$file->objectID]->files[] = $file;
        return $articles;
    }
    /**
     * get latest articles 
     *
     * @param string $categories
     * @param int $count
     * @access public
     * @return array
     */
    public function getLatestArticle($categories, $count)
    {
        return $this->dao->select('id, title')->from(TABLE_ARTICLE)->alias('t1')
            ->leftJoin(TABLE_ARTICLECATEGORY)->alias('t2')
            ->on('t1.id = t2.article')
            ->beginIF($categories)->andWhere('t2.category')->in($categories)->fi()
            ->orderBy('addedDate_desc')->limit($count)
            ->fetchPairs('id', 'title');
    }

    /**
     * Get comment counts 
     * 
     * @param string $articles 
     * @access public
     * @return array
     */
    public function getCommentCounts($articles)
    {
        $comments = $this->dao->select('objectID as id, count("*") as count')->from(TABLE_COMMENT)
            ->where('objectID')->in($articles)
            ->andWhere('status')->eq(1)
            ->groupBy('objectID')
            ->fetchPairs('id', 'count');
        foreach($articles as $article) if(!isset($comments[$article])) $comments[$article] = 0;
        return $comments;
    }

    /**
     * Create an article.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $article = fixer::input('post')
            ->add('addedDate', helper::now())
            ->remove('categories')
            ->get();

        $this->dao->insert(TABLE_ARTICLE)->data($article)->autoCheck()->batchCheck($this->config->article->create->requiredFields, 'notempty')->exec();

        if(!dao::isError()) $this->saveCategories($this->dao->lastInsertId());
        return;
    }

    /**
     * Update an article.
     * 
     * @param string $articleID 
     * @access public
     * @return void
     */
    public function update($articleID)
    {
        $article = fixer::input('post')->remove('category')->get();
        $this->dao->update(TABLE_ARTICLE)->data($article)->autoCheck()->batchCheck($this->config->article->create->requiredFields, 'notempty')->where('id')->eq($articleID)->exec();
        if(!dao::isError()) $this->saveCategories($articleID);
        return;
    }
        
    /**
     * save article categories.
     *
     * @param int $articleID
     *
     * @access private
     * @return bool
     */
    public function saveCategories($articleID)
    {
       if(!$articleID) return;
       $this->dao->delete()->from(TABLE_ARTICLECATEGORY)->where('article')->eq($articleID)->exec();

       $data = new stdClass();
       $data->article = $articleID;

       foreach($this->post->categories as $category)
       {
           if(!$category) continue;
           $data->category  = $category;
           $this->dao->insert(TABLE_ARTICLECATEGORY)->data($data)->exec();
       }
    }
 
    /**
     * Validate an article.
     * 
     * @access public
     * @return object
     */
    public function validate()
    {
        $error = array();
        if(array(0) == $this->post->categories) 
        {
            $error['categories'] = sprintf($this->lang->error->notempty, $this->lang->article->categories);
        }
        if(!$this->post->title)
        {
            $error['title'] = sprintf($this->lang->error->notempty, $this->lang->article->title);
        }
        if(!$this->post->content)
        {
            $error['content'] = sprintf($this->lang->error->notempty, $this->lang->article->content);
        }
        return $error;
    }

    /**
     * Delete an article
     * 
     * @param  string $articleID 
     * @access public
     * @return void
     */
    public function delete($articleID)
    {
        $this->dao->delete()->from(TABLE_ARTICLECATEGORY)->where('article')->eq($articleID)->exec();
        $this->dao->delete()->from(TABLE_ARTICLE)->where('id')->eq($articleID)->exec();
        return !dao::isError();
    }
}
