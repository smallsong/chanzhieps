<?php
include "../../../control.php";
class myIndex extends index 
{
    /**
     * Index.
     * 
     * @param  int    $moduleID  from article-browse
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function index($moduleID = 0, $recTotal = 0, $recPerPage = 0, $pageID = 1)
    {
        $this->view->moduleID = $moduleID;
        parent::index($recTotal, $recPerPage, $pageID);
    }
}
