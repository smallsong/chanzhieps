<?php
/**
 * The control file of help of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     help
 * @version     $Id: control.php 824 2010-05-02 15:32:06Z wwccss $
 * @link        http://www.xirang.biz
 */
class help extends control
{
    public function index()
    {
        $this->locate("http://www.xirang.biz/help-book-zentaopmshelp.html");
    }

    /**
     * Get the help info of an field of pms.
     * 
     * @param  string    $module 
     * @param  string    $method 
     * @param  string    $field 
     * @param  string    $clientLang 
     * @access public
     * @return void
     */
    public function field($module, $method, $field, $clientLang)
    {
        include "lang/field_$clientLang.php";

        $this->view->header->title = $this->lang->help->common;
        $this->view->module = $module;
        $this->view->method = $method;
        $this->view->field  = $field;
        $this->view->lang   = $lang;
        $this->display();
    }

    /**
     * Read a book.
     * 
     * @param  string $book 
     * @param  int    $moduleID 
     * @access public
     * @return void
     * @todo rewrite the logic of get order id.         
     */
    public function book($book, $moduleID = 0)
    {
        $this->app->loadLang('tree');
        $bookName = $this->lang->tree->lists[$book];

        $modules = $this->dao->select('id,name,grade,parent')->from(TABLE_MODULE)
            ->where('tree')->eq($book)
            ->beginIF($moduleID != 0)->andWhere('path')->like("%,$moduleID,%")->fi()
            ->orderBy('grade, `order`')->fetchAll('id');

        $articles = $this->dao->select('id, title, module')->from(TABLE_ARTICLE)
            ->alias('t1')->leftJoin(TABLE_ARTICLEMODULE)->alias('t2')->on('t1.id = t2.article')
            ->where('module')->in(@array_keys($modules))
            ->orderBy('`order`')
            ->fetchGroup('module', 'id', false);

        $bookModule   = $this->loadModel('tree')->getById($moduleID);
        $gradeModules = array();
        foreach($modules as $module)
        {
            if($module->grade == 1)
            {
                $gradeModules[$module->id] = $module;
                $gradeModules[$module->id]->i = $this->help->getOrderId($book, $module->id);
            }
            else
            {
                $j = $this->help->getOrderId($book, $module->id, $module->parent);
                $module->j = $j;
                $gradeModules[$module->parent]->childs[] = $module;
                if(!isset($gradeModules[$module->parent]->i)) $gradeModules[$module->parent]->i = $this->help->getOrderId($book, $module->parent);
            }
        }

        $this->view->header->title    = $bookName;
        if($bookModule)
        {
            $this->view->header->keywords = trim($bookModule->keyword . ' ' . $this->app->site->keywords);
            if($bookModule->desc) $this->view->header->desc = trim(preg_replace('/<[a-z\/]+.*>/Ui', '', $bookModule->desc));
        }

        $this->view->modules       = $gradeModules;
        $this->view->book->id      = $book;
        $this->view->book->name    = $bookName;
        $this->view->articles      = $articles;
        $this->view->module        = array('book'=>$this->view->book,'module'=>$bookModule);
        $this->view->layouts       = $this->loadModel('block')->getLayouts('help.book');
        $this->display();
    }

    /**
     * Read an article.
     * 
     * @param  int    $articleID 
     * @access public
     * @return void
     */
    public function read($articleID)
    { 
        $this->app->loadLang('tree');

        $article  = $this->loadModel('article')->getById($articleID, $this->config->help->imgMaxWidth);
        $module   = $this->loadModel('tree')->getById($article->module);
        $book     = $this->dao->findById($article->module)->from(TABLE_MODULE)->fetch('tree');
        $bookName = $this->lang->tree->lists[$book];
        $this->createContentNav(&$article->content);

        $this->view->header->title    = $article->title;
        $this->view->header->keywords = trim($article->keywords . ' ' . $module->keyword . ' ' . $this->app->site->keywords);
        $this->view->header->desc     = trim($article->summary . ' ' . preg_replace('/<[a-z\/]+.*>/Ui', '', $module->desc));

        $this->view->book->id      = $book;
        $this->view->book->name    = $bookName;
        $this->view->article       = $article;
        $this->view->links         = $this->article->getPairs($this->view->article->module, '`order`');
        $this->view->prevAndNext   = $this->help->getPrevAndNext($this->view->links, $article->id);
        $this->view->layouts       = $this->loadModel('block')->getLayouts('help.read');
        $this->view->module        = array('book' => $this->view->book, 'module' => $module);

        $this->dao->update(TABLE_ARTICLE)->set('views = views + 1')->where('id')->eq($articleID)->exec(false);

        $this->display();
    }

    /**
     * Create content navigation according the content. 
     * 
     * @param  int    $content 
     * @access public
     * @return string;
     */
    public function createContentNav($content)
    {
        $nav = "<div id='contentNav'>";
        $content = str_replace('<h3', '<h4', $content);
        $content = str_replace('h3>', 'h4>', $content);
        preg_match_all('|<h4.*>(.*)</h4>|isU', $content, $result);
        if(count($result[0]) >= 2)
        {
            foreach($result[0] as $id => $item)
            {
                $nav .= "<div><a href='#$id'>" . strip_tags($item) . "</a></div>";
                $replace = str_replace('<h4', "<h4 id=$id", $item);
                $content = str_replace($item, $replace, $content);
            }
            $nav .= "</div>";
            $content = $nav . $content;
        }
    }

    public function donation()
    {
        if($_POST)
        {
            if($this->post->money <= 10)
            {
                echo js::alert($this->lang->donation->sorry);
                die(js::reload('parent'));
            }

            $orderID = $this->help->saveOrder();
            if(!$orderID) die(js::error(dao::getError()));
            die(js::locate(inlink('payOrder', "orderID=$orderID"), 'parent'));
        }
        $this->view->donors = $this->help->getDonors();
        $this->display();
    }

    public function payOrder($orderID)
    {
        $this->loadModel('alipay');
        $order = $this->help->getOrderByRawID($orderID);
        $this->view->payLink = $this->alipay->createAlipayLink($order, 'donation');
        $this->view->order   = $order;
        $this->display();
    }

    public function processOrder($mode = 'return')
    {
        /* Get the orderID from the alipay. */
        $orderID = $this->loadModel('alipay')->getOrderFromAlipay($mode, 'donation');
        if(!$orderID) die('STOP!');

        /* Process the order. */
        $result = $this->help->processOrder($orderID);

        /* Notify mode. */
        if($mode == 'notify')
        {
            $this->alipay->saveAlipayLog();
            if($result == 'success') die('success');
            die('fail');
        }

        $this->view->result  = $result;
        $this->view->orderID = $orderID;
        $this->display();
    }

    public function export()
    {
        $this->app->loadLang('tree');
        if($_POST)
        {
            $modules = $this->dao->select('id, path, name, parent, grade')->from(TABLE_MODULE)
                ->where('tree')->eq($this->post->type)
                ->orderBy('grade desc, `order`')
                ->fetchAll('id');

            $this->post->set('modules', $modules);
            $this->post->set('kind', 'help');
            $this->post->set('fileName', $this->lang->tree->lists[$this->post->type]);
            $this->fetch('file', 'export2word', $_POST);
        }
        $this->display();
    }
}
