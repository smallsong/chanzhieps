<?php
/**
 * The control file of tree category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
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
     * @param  string $treeType 
     * @param  int    $root 
     * @access public
     * @return void
     */
    public function browse($treeType = 'article', $root = 0)
    {
        if($treeType == 'forum') $this->lang->category = $this->lang->board;

        $this->view->title    = $this->lang->category->common;
        $this->view->treeType = $treeType;
        $this->view->root     = $root;
        $this->view->treeMenu = $this->tree->getTreeMenu($treeType, 0, array('treeModel', 'createManageLink'));
        $this->view->children = $this->tree->getChildren($root, $treeType);

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

        /* If tree is forum, assign board to category. */
        if($category->tree == 'forum') $this->lang->category = $this->lang->board;

        if(!empty($_POST))
        {
            $this->tree->update($categoryID);
            if(!dao::isError())
            $this->send(array('result' => 'success'));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        /* Get option menu and remove the families of current category from it. */
        $optionMenu = $this->tree->getOptionMenu($category->tree);
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
     * @param  string    $tree 
     * @param  int       $category    the current category id.
     * @access public
     * @return void
     */
    public function children($tree, $category = 0)
    {
        /* If tree is forum, assign board to category. */
        if($tree == 'forum') $this->lang->category = $this->lang->board;

        if(!empty($_POST))
        { 
            $result = $this->tree->manageChildren($tree, $this->post->parent, $this->post->children);
            $locate = $this->inLink('browse', "tree=$tree&root={$this->post->parent}");
            if($result) $this->send(array('result' => 'success', 'locate' => $locate));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->title    = $this->lang->tree->manage;
        $this->view->tree     = $tree;
        $this->view->children = $this->tree->getChildren($category, $tree);
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
