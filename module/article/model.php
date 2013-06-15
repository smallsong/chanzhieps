<?php
/**
 * The model file of article module of XiRangBPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
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
        $article = $this->dao->select('*')->from(TABLE_ARTICLE)->where('id')->eq($articleId)->fetch('', false);
        if($article and empty($article->tree)) $article->tree = 'article';
        $article->files   = $this->loadModel('file')->getByObject('article', $articleId);
        $article->content = $this->file->setImgSize($article->content, $imgMaxWidth);
        foreach($article->files as $file) if($file->isImage and $file->public) $article->images[] = $file;
        return $article;
    }

    /**
     * Get article list.
     * 
     * @param string $modules 
     * @param string $orderBy 
     * @param string $pager 
     * @access public
     * @return array
     */
    public function getList($modules, $orderBy, $pager = null)
    {
        return $this->dao->select('*')->from(TABLE_ARTICLE)
            ->beginIF($modules)->where('module')->in($modules)->fi()
            ->orderBy($orderBy)
            ->page($pager, false)
            ->fetchAll('id', false);
    }

    /**
     * Get article pairs.
     * 
     * @param string $modules 
     * @param string $orderBy 
     * @param string $pager 
     * @access public
     * @return array
     */
    public function getPairs($modules, $orderBy, $pager = null)
    {
        return $this->dao->select('id, title')->from(TABLE_ARTICLE)
            ->beginIF($modules)->where('module')->in($modules)->fi()
            ->orderBy($orderBy)
            ->page($pager, false)
            ->fetchPairs('id', 'title', false);
    }

    /**
     * Get articles of an module.
     * 
     * @param string $moduleID  the module id
     * @param string $getFiles  get it's files or not
     * @param int $count 
     * @access public
     * @return array
     */
    public function getModuleArticle($moduleID, $getFiles = false, $count = 10)
    {
        $this->loadModel('tree');
        $childs = $this->tree->getAllChildId($moduleID);
        $articles = $this->dao->select('id, title, author, addedDate, summary')
            ->from(TABLE_ARTICLE)
            ->where('module')->in($childs)
            ->orderBy('id desc')->limit($count)->fetchAll('id', false);
        if(!$getFiles) return $articles;

        /* Fetch files. */
        $files = $this->loadModel('file')->getByObject('article', array_keys($articles));
        foreach($files as $file) $articles[$file->objectID]->files[] = $file;

        return $articles;
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
            ->fetchPairs('id', 'count', false);
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
        $article = fixer::input('post')->add('addedDate', helper::now())->get();
        $this->dao->insert(TABLE_ARTICLE)->data($article, false)->autoCheck()->batchCheck('title, content', 'notempty')->exec();
        if(!dao::isError())
        {
            $articleID = $this->dao->lastInsertID();
            $this->dao->update(TABLE_ARTICLE)->set('`order`')->eq($articleID)->where('id')->eq($articleID)->exec(false);    // set the order field.
        }
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
        $article = fixer::input('post')->add('editedDate', helper::now())->get();
        $this->dao->update(TABLE_ARTICLE)->data($article, false)->autoCheck()->batchCheck('title, content', 'notempty')->where('id')->eq($articleID)->exec(false);
        return;
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
        $this->dao->delete()->from(TABLE_ARTICLE)->where('id')->eq($articleID)->exec(false);
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
