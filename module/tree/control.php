<?php
/**
 * The control file of tree module of XiRangEPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class tree extends control
{
    const NEW_CHILD_COUNT = 5;

    /**
     * Browse the modules and print manage links.
     * 
     * @param string $tree 
     * @param int $currentModuleID 
     * @access public
     * @return void
     */
    public function browse($tree, $currentModuleID = 0)
    {
        $parentModules = $this->tree->getParents($currentModuleID);
        $this->view->tree            = $tree;
        $this->view->modules         = $this->tree->getTreeMenu($tree, $rooteModuleID = 0, array('treeModel', 'createManageLink'));
        $this->view->sons            = $this->tree->getSons($currentModuleID, $tree);
        $this->view->currentModuleID = $currentModuleID;
        $this->view->parentModules   = $parentModules;
        $this->display();
    }

    /**
     * Edit a module.
     * 
     * @param string $moduleID 
     * @param string $tree 
     * @access public
     * @return void
     */
    public function edit($moduleID, $tree)
    {
        if(!empty($_POST))
        {
            $this->tree->update($moduleID);
            echo js::alert($this->lang->tree->successSave);
            die(js::reload('parent'));
        }

        if($tree == 'forum')
        {
            /* Get current site. */
            $this->loadModel('site');
            $site = $this->site->getById($this->app->site->id);

            /* Get option menu, use site as index. */
            $allOptionMenu = array();
            $linkSites     = explode(',', $this->app->site->id . ',' . $site->linkSites);
            foreach($linkSites as $siteID)
            {
                $optionMenu = $this->tree->getOptionMenu('forum', 0, $siteID);
                if(count($optionMenu) == 1) continue;
                foreach($optionMenu as $itemID => $item) if(strpos($item, '/', 1) !== false) unset($optionMenu[$itemID]);
                $optionMenu = array('' => '') + $optionMenu;
                $allOptionMenu[$siteID] = $optionMenu;
            }

            /* Assigns. */
            $this->view->sites         = $this->site->getPairs();
            $this->view->allOptionMenu = $allOptionMenu;
            $this->view->modules       = $this->dao->select('*')->from(TABLE_MODULE)->where('id')->eq($moduleID)->fetchAll('site', false);
        }

        $this->view->module     = $this->tree->getById($moduleID);
        $this->view->optionMenu = $this->tree->getOptionMenu($this->view->module->tree);
        $this->view->tree       = $tree;

        /* Remove self and childs from the $optionMenu. */
        $childs = $this->tree->getAllChildId($moduleID);
        foreach($childs as $childModuleID) unset($this->tree->optionMenu[$childModuleID]);

        $this->display();
    }

    /**
     * Update the modules order.
     * 
     * @access public
     * @return void
     */
    public function updateOrder()
    {
        if(!empty($_POST))
        {
            $this->tree->updateOrder($_POST['orders']);
            die(js::reload('parent'));
        }
    }

    /**
     * Manage childs.
     * 
     * @param string $tree 
     * @access public
     * @return void
     */
    public function manageChild($tree)
    {
        if(!empty($_POST))
        {
            $this->tree->manageChild($tree, $_POST['parentModuleID'], $_POST['modules']);
            die(js::reload('parent'));
        }

    }

    /**
     * Fix path, grades.
     * 
     * @param  string    $tree 
     * @param  string    $type 
     * @access public
     * @return void
     */
    public function fix($tree)
    {
        $this->tree->fixModulePath($tree);
        die(js::alert($this->lang->tree->successFixed) . js::reload('parent'));
    }

    /**
     * Delete a module.
     * 
     * @param string $moduleID 
     * @param string $confirm 
     * @access public
     * @return void
     */
    public function delete($moduleID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->tree->confirmDelete, $this->createLink('tree', 'delete', "moduleID=$moduleID&confirm=yes"));
            exit;
        }
        else
        {
            $this->tree->delete($moduleID);
            die(js::reload('parent'));
        }
    }
}
