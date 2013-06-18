<?php
/**
 * The control file of search module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     search
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class search extends control
{
    /**
     * The google search page.
     * 
     * @access public
     * @return void
     */
    public function google()
    {
        $this->view->layouts = $this->loadModel('block')->getLayouts('search.list');
        $this->display();
    }

    /**
     * The bing search page.
     * 
     * @access public
     * @return void
     */
    public function bing()
    {
        $this->view->layouts = $this->loadModel('block')->getLayouts('search.list');
        $this->view->results = $this->search->getBingResult($this->post->key);
        $this->display();
    }

    /**
     * Create docs for xunsearch.
     * 
     * @access public
     * @return void
     */
    public function createDocs()
    {
        $docs = array();
        if(!$this->dbh->query("TRUNCATE TABLE " . TABLE_DOCS)) return false;
        foreach($this->config->search->xsTables as $table => $selectSQL)
        {
            $docs = $this->dao->select($selectSQL)->from($table)->fetchAll('', false);
            foreach($docs as $doc) 
            {
                if(isset($doc->site) and $doc->site != $this->app->site->id) continue;
                if(!isset($doc->site)) $doc->site = $this->app->site->id;
                $this->dao->insert(TABLE_DOCS)->data($doc)->exec();
            }
        }
        if(dao::isError())
        {
            echo dao::getError();
            die;
        }
        echo "create docs successfully!\n";
    }

    /**
     * The xunSearch 
     * 
     * @param  string $moduleName 
     * @access public
     * @return void
     */
    public function xunSearch($moduleName, $recTotal = 0, $recPerPage = 10, $pageID = 1)
    {
        $keywords = $this->get->key ? $this->get->key : $this->session->key;
        $keywords = trim($keywords);
        $this->session->set('key', $keywords);

        include_once "{$this->config->search->xsRoot}/sdk/php/lib/XS.php";
        try
        {
            $xs = new XS('zentaocms');
            $docs = $keywords != "" ? $xs->search->setQuery($keywords)->setLimit($recPerPage, ($pageID - 1) * $recPerPage)->search() : '';

            $this->app->loadClass('pager', $static = true);
            $this->view->pager        = new pager($xs->search->getLastCount(), $recPerPage, $pageID);
            $this->view->keywords     = $keywords ? $keywords : '&nbsp;';
            $this->view->module       = $moduleName;
            $this->view->relatedWords = $xs->search->getRelatedQuery($keywords, 10);
            $this->view->results      = $this->search->processDocs($docs, $xs->search);
            $this->view->hotWords     = $xs->search->getHotQuery();
        }
        catch (XSException $e)
        {
            echo $e;              
            if (defined('DEBUG')) echo "\n" . $e->getTraceAsString() . "\n";
        }

        $this->display();
    }
}
