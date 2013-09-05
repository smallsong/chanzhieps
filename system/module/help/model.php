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
    public function getOrderId($code, $categoryID, $parentID = '')
    {
        $allCategories = $this->dao->select('*')->from(TABLE_CATEGORY)
            ->where('type')->eq($code)
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
        $setting->key     = 'book_' . $book->code;
        unset($book->code);
        $setting->value   = helper::jsonEncode($book);

        $this->dao->insert(TABLE_CONFIG)->data($setting)->exec();

        return !dao::isError();
    }

    /**
     * Get a book by id.
     *
     * @param int $id
     * @access public
     * @return array
     */
    public function getBookByID($id)
    {
        $book = $this->dao->select('*')->from(TABLE_CONFIG)->where('id')->eq($id)->fetch();
        if(!$book) return false;

        $id   = $book->id;
        $key  = $book->key;    
        $book = json_decode($book->value);

        $book->id  = $id;
        $book->key = $key;

        return $book;
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
            ->orderBy('id_desc')
            ->limit(1)
            ->fetch();

        if(!$book) return false;

        $id   = $book->id;
        $key  = $book->key;    
        $book = json_decode($book->value);

        $book->id  = $id;
        $book->key = $key;

        return $book;
    }

    /**
     * Get book list.
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
            ->orderBy('id_desc')
            ->page($pager)
            ->fetchAll('id');

        foreach($books as $bookID => $book)
        {
            $id  = $book->id;
            $key = $book->key;
            $books[$bookID]      = json_decode($book->value);
            $books[$bookID]->key = $key;
            $books[$bookID]->id  = $id; 
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
        $key  = 'book_' . $book->code;
        unset($book->code);

        $this->dao->update(TABLE_CONFIG)
            ->set('key')->eq($key)
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
        $book = $this->getBookByID($id);
        if(!$book) return false;
        
        $this->dao->delete()->from(TABLE_CONFIG)->where('id')->eq($id)->exec();
        $this->dao->delete()->from(TABLE_CATEGORY)->where('type')->eq($book->key)->exec();
        $this->dao->delete()->from(TABLE_RELATION)->where('type')->eq($book->key)->exec();

        return !dao::isError();
    }
}
