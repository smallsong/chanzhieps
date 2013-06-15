<?php

class admin extends control
{
    /**
     * The left menu.
     *
     * @param string $tree
     * @access public
     * @return void
     */
    public function leftmenu()
    {
        $this->view->tree     = 'rss';
        $this->view->treeMenu = $this->loadModel('tree')->getTreeMenu('rss', $startModuleID = 0, array('exttreeModel', 'createAdminLink'));
        $this->display();
    }
}

