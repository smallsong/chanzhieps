<?php
class tree extends control
{
    const NEW_CHILD_COUNT = 5;

    public function browse($tree, $currentModuleID = 0)
    {
        if($tree == 'video')
        {
            $parentModules = $this->tree->getParents($currentModuleID);
            $this->view->tree            = $tree;
            $this->view->modules         = $this->tree->getTreeMenu($tree, $rooteModuleID = 0, array('treeModel', 'createManageLink'));
            $this->view->sons            = $this->tree->getSons($currentModuleID, $tree);
            $this->view->currentModuleID = $currentModuleID;
            $this->view->parentModules   = $parentModules;
        }
        else
        {
            $parentModules = $this->tree->getParents($currentModuleID);
            $this->view->tree            = $tree;
            $this->view->modules         = $this->tree->getTreeMenu($tree, $rooteModuleID = 0, array('treeModel', 'createManageLink'));
            $this->view->sons            = $this->tree->getSons($currentModuleID, $tree);
            $this->view->currentModuleID = $currentModuleID;
            $this->view->parentModules   = $parentModules;
        }
        $this->display();
    }
}
