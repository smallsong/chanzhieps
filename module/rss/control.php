<?php
/**
 * The control file of rss module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     rss
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class rss extends control
{
    /**
     * Output the rss.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, $this->config->rss->items, 1);

        $modules  = $this->loadModel('tree')->getPairs('', 'article');
        $articles = $this->loadModel('article')->getList(array_keys($modules), 'id desc', $pager);
        $this->article->createDigest($articles);
        $latestArticle = current($articles);

        $this->view->title    = $this->app->site->name;
        $this->view->siteLink = commonModel::getSysURL();
        $this->view->modules  = $modules;
        $this->view->articles = $articles;
        $this->view->lastDate = $latestArticle->addedDate . ' +0800';
        die($this->display());
    }
}
