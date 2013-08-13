<?php
/**
 * The model file of article category of xirangEPS.
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
     * Get an article by id.
     * 
     * @param  int      $articleID 
     * @access public
     * @return bool|object
     */
    public function getByID($articleID)
    {   
        /* Get article self. */
        $article = $this->dao->select('*')
            ->from(TABLE_ARTICLE)
            ->where('id')->eq($articleID)
            ->fetch();
        if(!$article) return false;

        /* Get it's categories. */
        $article->categories = $this->dao->select('t2.*')
            ->from(TABLE_RELATION)->alias('t1')
            ->leftJoin(TABLE_CATEGORY)->alias('t2')->on('t1.category = t2.id')
            ->where('t1.type')->eq($article->type)
            ->andWhere('t1.id')->eq($articleID)
            ->fetchAll('id');

        /* Get article path to highlight main nav. */
        $path = '';
        foreach($article->categories as $category) $path .= $category->path;
        $article->path = explode(',', trim($path, ','));

        /* Get it's files. */
        $article->files = $this->loadModel('file')->getByObject('article', $articleID);

        return $article;
    }   

    /** 
     * Get article list.
     * 
     * @param  array   $categories 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($categories, $orderBy, $pager = null)
    {
        /* Get articles(use groupBy to distinct articles).  */
        $articles = $this->dao->select('t1.*, t2.category')->from(TABLE_ARTICLE)->alias('t1')
            ->leftJoin(TABLE_RELATION)->alias('t2')->on('t1.id = t2.id')
            ->where('1 = 1')
            ->beginIF($categories)->andWhere('t2.category')->in($categories)->fi()
            ->groupBy('t2.id')
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
        if(!$articles) return array();

        /* Get categories for these articles. */
        $categories = $this->dao->select('t2.id, t2.name, t1.id AS article')
            ->from(TABLE_RELATION)->alias('t1')
            ->leftJoin(TABLE_CATEGORY)->alias('t2')->on('t1.category = t2.id')
            ->where('1 = 1')
            ->beginIF($categories)->andWhere('t1.category')->in($categories)->fi()
            ->fetchGroup('article', 'id');

        $images = $this->loadModel('file')->getByObjectList('article', array_keys($articles), $isImage = true);

        /* Assign categories to it's article. */
        foreach($articles as $article) $article->categories = $categories[$article->id];

        /* Assign images to it's article. */
        foreach($articles as $article) $article->images = $images[$article->id];

        return $articles;
    }

    /**
     * get latest articles. 
     *
     * @param array      $categories
     * @param int        $count
     * @access public
     * @return array
     */
    public function getLatest($categories, $count)
    {
        return $this->dao->select('t1.id, t1.title')
            ->from(TABLE_ARTICLE)->alias('t1')
            ->leftJoin(TABLE_RELATION)->alias('t2')->on('t1.id = t2.id')
            ->beginIF($categories)->andWhere('t2.category')->in($categories)->fi()
            ->orderBy('id_desc')
            ->limit($count)
            ->fetchPairs('id', 'title');
    }

    /**
     * Create an article.
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $article = fixer::input('post')
            ->join('categories', ',')
            ->add('addedDate', helper::now())
            ->add('type', 'article')
            ->get();

        $this->dao->insert(TABLE_ARTICLE)
            ->data($article, $skip = 'categories')
            ->autoCheck()
            ->batchCheck($this->config->article->create->requiredFields, 'notempty')
            ->exec();

        if(dao::isError()) return false;

        $articleID = $this->dao->lastInsertID();
        $this->processCategories($articleID, 'article', $this->post->categories);
        return $articleID;
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
        $article = fixer::input('post')
            ->remove('categories')
            ->add('editor', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->get();

        $this->dao->update(TABLE_ARTICLE)
            ->data($article)
            ->autoCheck()
            ->batchCheck($this->config->article->edit->requiredFields, 'notempty')
            ->where('id')->eq($articleID)
            ->exec();
        if(!dao::isError()) $this->processCategories($articleID, 'article', $this->post->categories);
        return;
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
        $article = $this->getByID($articleID);
        if(!$article) return false;

        $this->dao->delete()->from(TABLE_RELATION)->where('id')->eq($articleID)->andWhere('type')->eq($article->type)->exec();
        $this->dao->delete()->from(TABLE_ARTICLE)->where('id')->eq($articleID)->exec();

        return !dao::isError();
    }

    /**
     * Process categories for an article.
     * 
     * @param  int    $articleID 
     * @param  string $tree
     * @param  array  $categories 
     * @access public
     * @return void
     */
    public function processCategories($articleID, $type = 'article', $categories = array())
    {
       if(!$articleID) return false;

       /* First delete all the records of current article from the releation table.  */
       $this->dao->delete()->from(TABLE_RELATION)
           ->where('type')->eq($type)
           ->andWhere('id')->eq($articleID)
           ->autoCheck()
           ->batchCheck('type,id', 'notempty')
           ->exec();

       /* Then insert the new data. */
       foreach($categories as $category)
       {
           if(!$category) continue;

           $data = new stdClass();
           $data->type     = $type; 
           $data->id       = $articleID;
           $data->category = $category;

           $this->dao->insert(TABLE_RELATION)->data($data)->exec();
       }
    }

    /**
     * Create preview link. 
     * 
     * @param  int    $articleID 
     * @param  string $type         article|help
     * @access public
     * @return string
     */
    public function createPreviewLink($articleID, $type = 'article')
    {
        $module = $type == 'article' ? 'article' : 'help';
        $method = $type == 'article' ? 'view'    : 'read';

        return commonModel::createFrontLink($module, $method, "articleID=$articleID");
    }
}
