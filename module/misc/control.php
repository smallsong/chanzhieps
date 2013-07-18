<?php
/**
 * The control file of misc of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     misc
 * @version     $Id: control.php 824 2010-05-02 15:32:06Z wwccss $
 * @link        http://www.xirang.biz
 */
class misc extends control
{
    /**
     * Ping the server ervery 5 minutes to keep the session.
     * 
     * @access public
     * @return void
     */
    public function ping()
    {
        die("<html><head><meta http-equiv='refresh' content='300' /></head><body></body></html>");
    }

    /**
     * Show the phpinfo.
     * 
     * @access public
     * @return void
     */
    public function phpinfo()
    {
        die(phpinfo());
    }

    /**
     * Fix comments.
     * 
     * @access public
     * @return void
     */
    public function fixComment()
    {
        $comments = $this->loadModel('comment')->getList(1);
        $this->dao->update(TABLE_ARTICLE)->set('`type`')->eq('common')->exec(false);
        $modules = $this->dao->select('id')->from(TABLE_MODULE)->where('tree')->in(array('zentaopmshelp', 'xirangEPShelp'))->fetchpairs('id', 'id', false);
        $articles = $this->dao->select('article')->from(TABLE_ARTICLEMODULE)->where('module')->in($modules)->fetchPairs('article', 'article', false);
        $this->dao->update(TABLE_ARTICLE)->set('`type`')->eq('doc')->where('id')->in($articles)->exec(false);

        foreach($comments as $comment)
        {
            $sites = $this->dao->select('site')->from(TABLE_ARTICLEMODULE)->where('article')->eq($comment->objectID)->fetchPairs('site', 'site', false);
            foreach($sites as $siteID)
            {
                $data->comment = $comment->id;
                $data->site    = $siteID;
                $data->status  = 1;
                $this->dao->replace(TABLE_COMMENTSITE)->data($data)->exec();
            }
            $articleType = $this->dao->findById($comment->objectID)->from(TABLE_ARTICLE)->fetch('type', false);
            $this->dao->update(TABLE_COMMENT)->set('objectType')->eq($articleType)->where('id')->eq($comment->id)->exec(false);
        }
    }

    /**
     * Fix articles.
     * 
     * @access public
     * @return void
     */
    public function fixArticle()
    {
        $this->loadModel('mail');
        $articles = $this->dao->select('article')->from(TABLE_ARTICLEMODULE)->groupBy('article')->fetchPairs('article', 'article', false);
        foreach($articles as $articleID)
        {
            $article = $this->dao->findById($articleID)->from(TABLE_ARTICLE)->fetch('id', false);
            if(!$article)
            {
                echo $article . " \n";
                $this->dao->delete()->from(TABLE_ARTICLEMODULE)->where('article')->eq($articleID)->exec(false);
            }
        }
    }

    /**
     * Get latest release 
     * 
     * @access public
     * @return string
     */
    public function getLatestRelease()
    {
        $release->version = $this->config->updater->latestVersion;
        $release->date    = $this->config->updater->latestDate;
        $release->url     = $this->config->updater->latestLink;
        $data->release    = $release;
        die(json_encode($data));
    }
}
