<?php
class thread extends control
{
    public function view($threadID, $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->view->thread = $this->thread->getByID($threadID, $pager);
        $this->view->pager  = $pager;
        $this->view->users  = $this->loadModel('user')->getBasicInfo($this->thread->extractUsers($this->view->thread));
        $this->view->board  = $this->loadModel('tree')->getById($this->view->thread->module);
        $this->view->layouts= $this->loadModel('block')->getLayouts('thread.view');
        $this->view->header->title = $this->view->thread->title . '|' . $this->view->board->name;
        $this->dao->update(TABLE_THREAD)->set('views = views + 1')->where('id')->eq($threadID)->exec();
        $this->loadModel('data')->updateArticleVisit('thread', $threadID);
        $this->display();
    }
}
