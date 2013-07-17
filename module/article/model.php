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
        $article = $this->dao->select('*')->from(TABLE_ARTICLE)->alias('t1')
            ->leftJoin(TABLE_ARTICLECATEGORY)->alias('t2')
            ->on('t1.id = t2.article')
            ->where('t1.id')->eq($articleId)
            ->fetch('');
        if($article and empty($article->tree)) $article->tree = 'article';
        $article->files   = $this->loadModel('file')->getByObject('article', $articleId);
        $article->content = $this->file->setImgSize($article->content, $imgMaxWidth);
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
            ->leftJoin(TABLE_ARTICLECATEGORY)->alias('t2')
            ->on('t1.id = t2.article')
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
     * Get the categories in other sites for an article.
     * 
     * @param  string $articleID 
     * @access public
     * @return array
     */
    public function getOtherSiteCategories($articleID)
    {
        return $this->dao->select('site, category')->from(TABLE_ARTICLECATEGORY)
            ->where('article')->eq($articleID)
            ->andWhere('site')->ne($this->session->site->id)
            ->fetchPairs('site', 'category');
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
        $article = fixer::input('post')->remove('categories')->add('addedDate', helper::now())->get();

        $this->dao->insert(TABLE_ARTICLE)->data($article)->autoCheck()->batchCheck($this->config->article->create->requiredFields, 'notempty')->exec();

        if(!dao::isError())
        {
            $articleID = $this->dao->lastInsertID();
            $this->dao->update(TABLE_ARTICLE)->set('`order`')->eq($articleID)->where('id')->eq($articleID)->exec();    // set the order field.
            foreach($this->post->categories as $siteID => $categoryID)
            {
                $data = new stdClass();
                if(!$categoryID) continue;
                $data->article = $articleID;
                $data->category  = $categoryID;
                $this->dao->insert(TABLE_ARTICLECATEGORY)->data($data)->exec();
            }
        }
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
        if(!dao::isError())
        {
            $categoryID = $this->post->category;
            {
                $this->dao->delete()->from(TABLE_ARTICLECATEGORY)
                    ->where('article')->eq($articleID)
                    ->exec();

                if($categoryID)
                {
                    $data = new stdClass();
                    $data->category  = $categoryID;
                    $data->article = $articleID;
                    $this->dao->insert(TABLE_ARTICLECATEGORY)->data($data)->exec();
                }
            }
        }
        return;
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

    /**
     * Create digest for articles. 
     * 
     * @param string $articles 
     * @access public
     * @return void
     */
    public function createDigest($articles)
    {
        $this->loadModel('file');

        foreach($articles as $article)
        {
            $digestLength = $this->config->article->digest;
            /*  If the length of content litter than the setting, return directly. */
            if(mb_strlen($article->content) <= $digestLength)
            {
                $article->digest = $this->file->setImgSize($article->content);
            }
            else
            {
                /* substr the digest from the content. */
                if($article->content[$digestLength] != "\n")
                {
                    $newDigestLength = mb_strpos($article->content, "\n", $digestLength);
                    if($newDigestLength) $digestLength = $newDigestLength;
                }
                $digest = mb_substr($article->content, 0, $digestLength);
                $digest = tidy_repair_string($digest, array('show-body-only'=> true), 'UTF8');   // repair the unclosed tags.
                $digest = $this->file->setImgSize($digest);
                $article->digest = trim($digest);
            }
        }
    }
}
