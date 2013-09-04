<?php
/**
 * The model file of help category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     help
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class helpModel extends model
{
    /**
     * getOrderId 
     * 
     * @param  string    $book 
     * @param  string    $categoryID 
     * @param  id        $parentID 
     * @access public
     * @return void
     * @todo rewrite the logic.
     */
    public function getOrderId($book, $categoryID, $parentID = '')
    {
        $allCategories = $this->dao->select('*')->from(TABLE_CATEGORY)
            ->where('type')->eq('help')
            ->andwhere('book')->eq($book)
            ->beginIF($parentID !='')->andWhere('parent')->eq($parentID)->fi()
            ->orderBy('grade, `order`')->fetchAll('id');
        $order = 1;
        foreach($allCategories as $thisCategory)
        {
            if($categoryID == $thisCategory->id)break;
            $order++;
        }
        return $order;
    }

    /**
     * Get donors 
     * 
     * @access public
     * @return array
     */
    public function getDonors()
    {
        return $this->dao->select('*')->from(TABLE_DONATION)->where('status')->eq('paid')->orderBy('id desc')->fetchAll('id', false);
    }

    public function saveOrder()
    {
        $data = fixer::input('post')
            ->add('createdDate', helper::now())
            ->add('account', $this->app->user->account)
            ->add('status', 'wait')
            ->setDefault('name', 'guest')
            ->get();
        $this->dao->insert(TABLE_DONATION)->data($data, false)->check('money', 'notempty')->exec();
        if(!dao::isError()) return $this->dao->lastInsertID();
        return false;
    }

    public function getOrderByRawID($rawOrder)
    {
        $order = $this->dao->select('*')->from(TABLE_DONATION)->where('id')->eq((int)$rawOrder)->fetch('', false);
        $order->subject = $this->lang->help->donation;
        if(!$order) return false;
        $this->loadModel('alipay');
        $order->humanOrder = $this->alipay->getHumanOrder($order->id);
        return $order;
    }

    public function processOrder($orderID)
    {
        /* Get order and site. */
        $order = $this->getOrderByRawID($orderID);

        $result = $this->loadModel('alipay')->processOrder($order, 'donation');
        if($result == 'success' and $order->status == 'wait' and $order->account != 'guest')
        {
            return $this->dao->update(TABLE_USER)->set('love = love + ' . $order->money)->where('account')->eq($order->account)->exec();
        }
        else
        {
            return $result;
        }
    }

    /**
     * Get the prev and next ariticle.
     * 
     * @param  array  $links    the link articles.
     * @param  int    $current  the current article id.
     * @access public
     * @return array
     */
    public function getPrevAndNext($links, $current)
    {
        $prev = array();
        $next = array();
        $keys = array_keys($links);

        $currentKey = array_search($current, $keys);
        $prevKey    = $currentKey - 1;
        $nextKey    = $currentKey + 1;

        if(isset($keys[$prevKey])) $prev = array('id' => $keys[$prevKey], 'title' => $links[$keys[$prevKey]]);
        if(isset($keys[$nextKey])) $next = array('id' => $keys[$nextKey], 'title' => $links[$keys[$nextKey]]);

        return array('prev' => $prev, 'next' => $next);
    }

    /**
     * Create a book.
     *
     * @access public
     * @return bool
     */
    public function createBook()
    {
        $book = fixer::input('post')->add('addedDate', helper::now())->get();

        $setting = new stdclass();
        $setting->owner   = 'system';
        $setting->module  = 'common';
        $setting->section = 'book';
        $setting->value   = helper::jsonEncode($book);

        $bookKeys     = isset($this->config->book) ? array_keys((array)$this->config->book) : array(0);
        $setting->key = max($bookKeys) + 1;

        $this->dao->insert(TABLE_CONFIG)->data($setting)->exec();

        return !dao::isError();
    }

    /**
     * Get one book by id.
     *
     * @param int $id
     * @access public
     * @return array
     */
    public function getBookByID($id)
    {
        $book = $this->dao->select('*')->from(TABLE_CONFIG)->where('id')->eq($id)->fetch();
        if(!$book) return false;

        return json_decode($book->value);
    }

    /**
     * Get the first book.
     * 
     * @access public
     * @return object|bool
     */
    public function getFirstBook()
    {
        $book = $this->dao->select('*')->from(TABLE_CONFIG)
            ->where('owner')->eq('system')
            ->andWhere('module')->eq('common')
            ->andWhere('section')->eq('book')
            ->orderBy('id')
            ->limit(1)
            ->fetch();

        if(!$book) return false;

        return json_decode($book->value);
    }

    /**
     * Get book list sorted by key.
     *
     * @access public
     * @return array
     */
    public function getBookList($pager = null)
    {
        $books = $this->dao->select('*')->from(TABLE_CONFIG)
            ->where('owner')->eq('system')
            ->andWhere('module')->eq('common')
            ->andWhere('section')->eq('book')
            ->orderBy('`key`')
            ->page($pager)
            ->fetchAll('key');

        foreach($books as $key => $book)
        {
            $id = $book->id;
            $books[$key] = json_decode($book->value);
            $books[$key]->id = $id; 
        }

        return $books;
    }

    /**
     * Update a book.
     *
     * @param int $id
     * @access public
     * @return bool
     */
    public function updateBook($id)
    {

        $book = fixer::input('post')->get();

        $this->dao->update(TABLE_CONFIG)
            ->set('value')->eq(helper::jsonEncode($book))
            ->where('id')->eq($id)
            ->exec();
        return !dao::isError();
    }

    /**
     * Delete a book.
     *
     * @param int $id
     * @return bool
     */
    public function deleteBook($id)
    {
        $this->dao->delete()->from(TABLE_CONFIG)
            ->where('id')->eq($id)
            ->exec();
        return !dao::isError();
    }
}
