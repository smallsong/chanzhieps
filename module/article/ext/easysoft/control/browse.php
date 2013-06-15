<?php
include '../../../control.php';
class myArticle extends article
{
    /**
     * Browse of article. 
     * 
     * @param  int    $moduleID 
     * @access public
     * @return void
     */
    public function browse($moduleID, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 8, $pageID = 1)
    {
        /* The dynamic list. */
        if($moduleID == 8)
        {
            parent::browse($moduleID, $orderBy, $recTotal, $recPerPage, $pageID);
        }
        else
        {
            /* if access http://local.cnezsoft.com/article-browse-1067(1078/1080).html directly, go the products.html.php(services.html.php/aboutUs.html.php) of index module.*/
            $this->locate($this->createLink('index', 'index', "moduleID=$moduleID"));
        }
    }
}
