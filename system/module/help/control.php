<?php
/**
 * The control file of help category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     help
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class help extends control
{
    public function index()
    {
        $book = $this->help->getFirstBook();
        if($book) $this->locate(inlink('book', "bood=$book->code"));
        $this->locate($this->createLink('index'));
    }

    /**
     * Browse slides in admin.
     * 
     * @access public
     * @return void
     */
    public function admin($recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->view->books = $this->help->getBookList($pager);
        $this->view->pager = $pager;
        $this->display();
    }

    /**
     * Get the help info of an field.
     * 
     * @param  string    $category 
     * @param  string    $method 
     * @param  string    $field 
     * @param  string    $clientLang 
     * @access public
     * @return void
     */
    public function field($category, $method, $field, $clientLang)
    {
        include "lang/field_$clientLang.php";

        $this->view->header->title = $this->lang->help->common;
        $this->view->category = $category;
        $this->view->method = $method;
        $this->view->field  = $field;
        $this->view->lang   = $lang;
        $this->display();
    }

    /**
     * Create a book.
     *
     * @access public 
     * @return void
     */
    public function createBook()
    {
        if($_POST)
        {
            if(empty($_POST['name']) && empty($_POST['code'])) $this->send(array('result' => 'fail', 'message' => $this->lang->help->namenotempty . ' ' . $this->lang->help->codenotempty));
            if(empty($_POST['name'])) $this->send(array('result' => 'fail', 'message' => $this->lang->help->namenotempty));
            if(empty($_POST['code'])) $this->send(array('result' => 'fail', 'message' => $this->lang->help->codenotempty));
            if($this->help->createBook())
            {
                $this->send(array('result' => 'success', 'locate' => $this->inlink('admin')));
            }

            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }

        $this->display(); 
    }

    /**
     * Edit a book.
     *
     * @param int $id
     * @access public
     * @return void
     */
    public function editBook($id)
    {
        if($_POST)
        {
            if($this->help->updateBook($id))
            $this->send(array('result' => 'success', 'locate'=>$this->inLink('admin')) );
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }

        $this->view->id    = $id;
        $this->view->book  = $this->help->getBookByID($id);
        $this->display();
    }

    /**
     * Delete a book.
     *
     * @param int $id
     * @retturn void
     */
    public function deleteBook($id)
    {
        if($this->help->deleteBook($id)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Read a book.
     * 
     * @param  string $book 
     * @param  int    $categoryID 
     * @access public
     * @return void
     * @todo rewrite the logic of get order id.         
     */
    public function book($book, $categoryID = 0)
    {
        $categories = $this->dao->select('id,name,grade,parent')->from(TABLE_CATEGORY)
            ->where('type')->eq('help')
            ->andwhere('book')->eq($book)
            ->beginIF($categoryID != 0)->andWhere('path')->like("%,$categoryID,%")->fi()
            ->orderBy('grade, `order`')->fetchAll('id');

        $articles = $this->dao->select('t1.id, title, t2.category')->from(TABLE_ARTICLE)
            ->alias('t1')->leftJoin(TABLE_RELATION)->alias('t2')->on('t1.id = t2.id')
            ->where('category')->in(array_keys($categories))
            ->orderBy('id_desc')
            ->fetchGroup('category', 'id', false);

        $bookCategory    = $this->loadModel('tree')->getById($categoryID);
        $gradeCategories = array();
        foreach($categories as $category)
        {
            if($category->grade == 1)
            {
                $gradeCategories[$category->id]    = $category;
                $gradeCategories[$category->id]->i = $this->help->getOrderId($book, $category->id);
            }
            else
            {
                $j = $this->help->getOrderId($book, $category->id, $category->parent);
                $category->j = $j;
                $gradeCategories[$category->parent]->children[] = $category;
                if(!isset($gradeCategories[$category->parent]->i)) $gradeCategories[$category->parent]->i = $this->help->getOrderId($book, $category->parent);
            }
        }

        $this->view->header->title = $book;
        if($bookCategory)
        {
            $this->view->header->keywords = trim($bookCategory->keyword . ' ' . $this->app->site->keywords);
            if($bookCategory->desc) $this->view->header->desc = trim(preg_replace('/<[a-z\/]+.*>/Ui', '', $bookCategory->desc));
        }

        $this->view->books      = $this->help->getBookList();
        $this->view->categories = $gradeCategories;
        $this->view->book       = $book;
        $this->view->articles   = $articles;
        $this->view->category   = array('book'=>$this->view->book,'category'=>$bookCategory);
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
        $category = $this->loadModel('tree')->getById($article->category);
        $book     = $this->dao->findById($article->category)->from(TABLE_CATEGORY)->fetch('type');
        $bookName = $this->lang->tree->lists[$book];
        $this->createContentNav($article->content);

        $this->view->header->title    = $article->title;
        $this->view->header->keywords = trim($article->keywords . ' ' . $category->keyword . ' ' . $this->app->site->keywords);
        $this->view->header->desc     = trim($article->summary . ' ' . preg_replace('/<[a-z\/]+.*>/Ui', '', $category->desc));

        $this->view->book->id      = $book;
        $this->view->book->name    = $bookName;
        $this->view->article       = $article;
        $this->view->links         = $this->article->getLatest($this->view->article->category);
        $this->view->prevAndNext   = $this->help->getPrevAndNext($this->view->links, $article->id);
        $this->view->layouts       = $this->loadModel('block')->getLayouts('help.read');
        $this->view->category      = array('book' => $this->view->book, 'category' => $category);

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
            $categories = $this->dao->select('id, path, name, parent, grade')->from(TABLE_CATEGORY)
                ->where('tree')->eq($this->post->type)
                ->orderBy('grade desc, `order`')
                ->fetchAll('id');

            $this->post->set('categories', $categories);
            $this->post->set('kind', 'help');
            $this->post->set('fileName', $this->lang->tree->lists[$this->post->type]);
            $this->fetch('file', 'export2word', $_POST);
        }
        $this->display();
    }
}