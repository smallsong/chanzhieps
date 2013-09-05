<?php
/**
 * The control file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class block extends control
{
    /**
     * Browse block.
     * 
     * @access public
     * @return void
     */
    public function browse()
    {
        $this->view->blocks = $this->block->getList();
        $this->display();
    }

    /**
     * Create a block.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $this->block->create();
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate(inlink('browse'), 'parent'));
        }
        $this->display();
    }

    /**
     * Edit a block.
     * 
     * @param string $blockID 
     * @access public
     * @return void
     */
    public function edit($blockID)
    {
        if($_POST)
        {
            $this->block->update($blockID);
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate(inlink('browse'), 'parent'));
        }
        $this->view->block = $this->block->getById($blockID);
        $this->display();
    }

    /**
     * Set the layouts of one page.
     * 
     * @param string $page 
     * @access public
     * @return void
     */
    public function setPage($page)
    {
        if($_POST)
        {
            $this->block->setPage($page);
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::alert($this->lang->block->successSave) . js::reload('parent'));
        }

        /* Get all block pairs. */
        $allBlocks = $this->block->getPairs();
        $allBlocks[0] = '';
        asort($allBlocks);

        $this->view->allBlocks = $allBlocks;
        $this->view->layouts   = $this->block->getLayoutPairs($page, $includeAll = false);
        $this->display();
    }

    /**
     * View a block.
     * 
     * @param string $blockID 
     * @access public
     * @return void
     */
    public function view($blockID)
    {
        $this->view->block = $this->block->getById($blockID);
        $this->display();
    }

    /**
     * Delete a block.
     * 
     * @param string $blockID 
     * @param string $confirm 
     * @access public
     * @return void
     */
    public function delete($blockID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->block->confirmDelete, inlink('delete', "blockID=$blockID&confirm=yes"));
            exit;
        }
        else
        {
            $this->block->delete(TABLE_BLOCK, $blockID);
            die(js::reload('parent'));
        }
    }
}
