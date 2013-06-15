<?php
class article extends control
{
    public function view($articleID)
    {
        $article = $this->article->getById($articleID);
        if(RUN_MODE == 'front')
        { 
            $this->view->layouts          = $this->loadModel('block')->getLayouts('article.view');
            $this->view->articleTree      = $this->loadModel('tree')->getTreeMenu('article', 0, array('treeModel', 'createBrowseLink'));
            $this->view->module           = $this->tree->getById($article->module);

            $this->view->header->title    = $article->title . (isset($this->view->module->name) ? '|' . $this->view->module->name : '');
            $this->view->header->keywords = trim($article->keywords . ' ' . $this->view->module->keyword . ' ' . $this->app->site->keywords);
            $this->view->header->desc     = trim($article->summary . ' ' .preg_replace('/<[a-z\/]+.*>/Ui', '', $this->view->module->desc));

            $this->dao->update(TABLE_ARTICLE)->set('views = views + 1')->where('id')->eq($articleID)->exec(false);
            $this->loadModel('data')->updateArticleVisit('article', $articleID);
        }
        $this->view->article = $article;

        $this->display();
    }
}
