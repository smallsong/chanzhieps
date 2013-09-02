<?php
/**
 * The control file of tree category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class tree extends control
{
    const NEW_CHILD_COUNT = 5;

    /**
     * Browse the categories and print manage links.
     * 
     * @param  string $type 
     * @param  int    $root 
     * @access public
     * @return void
     */
    public function browse($type = 'article', $book = '', $root = 0)
    {
        if($type == 'forum')
        {
            $this->lang->category   = $this->lang->board;
            $this->lang->tree->menu = $this->lang->forum->menu;
            $this->lang->menuGroups->tree = 'forum';
        }

        if($type == 'product')
        {
            $this->lang->tree->menu = $this->lang->product->menu;
            $this->lang->menuGroups->tree = 'product';
        }

        if($type == help)
        {
            $this->lang->category         = $this->lang->directory;
            $this->lang->tree->menu       = $this->lang->book->menu;
            $this->lang->menuGroups->tree = 'help';
        }

        $this->view->title    = $this->lang->category->common;
        $this->view->type     = $type;
        $this->view->book     = $book;
        $this->view->root     = $root;
        $this->view->treeMenu = $this->tree->getTreeMenu($type, $book, 0, array('treeModel', 'createManageLink'));
        $this->view->children = $this->tree->getChildren($root, $type, $book);

        $this->display();
    }

    /**
     * Edit a category.
     * 
     * @param  int      $categoryID 
     * @access public
     * @return void
     */
    public function edit($categoryID)
    {
        /* Get current category. */
        $category = $this->tree->getById($categoryID);

        /* If type is forum, assign board to category. */
        if($category->type == 'forum') $this->lang->category = $this->lang->board;
        if($category->type == 'help')  $this->lang->category = $this->lang->directory;

        if(!empty($_POST))
        {
            $this->tree->update($categoryID);
            if(!dao::isError()) $this->send(array('result' => 'success'));

            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        /* Get option menu and remove the families of current category from it. */
        $optionMenu = $this->tree->getOptionMenu($category->type, $category->book);
        $families   = $this->tree->getFamily($categoryID);
        foreach($families as $member) unset($optionMenu[$member]);

        /* Assign. */
        $this->view->category   = $category;
        $this->view->optionMenu = $optionMenu;

        $this->display();
    }

    /**
     * Manage children.
     *
     * @param  string    $type 
     * @param  string    $book 
     * @param  int       $category    the current category id.
     * @access public
     * @return void
     */
    public function children($type, $book = '', $category = 0)
    {
        /* If type is forum, assign board to category. */
        if($type == 'forum') $this->lang->category = $this->lang->board;
        if($type == 'help')  $this->lang->category = $this->lang->directory;

        if(!empty($_POST))
        { 
            $result = $this->tree->manageChildren($type, $book, $this->post->parent, $this->post->children);
            $locate = $this->inLink('browse', "type=$type&book=$book&root={$this->post->parent}");
            if($result) $this->send(array('result' => 'success', 'locate' => $locate));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->title    = $this->lang->tree->manage;
        $this->view->type     = $type;
        $this->view->book     = $book;
        $this->view->children = $this->tree->getChildren($category, $type, $book);
        $this->view->origins  = $this->tree->getOrigin($category);
        $this->view->parent   = $category;

        $this->display();
    }

    /**
     * Delete a category.
     * 
     * @param  int    $category 
     * @access public
     * @return void
     */
    public function delete($category)
    {
        if($this->tree->delete($category)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
}
