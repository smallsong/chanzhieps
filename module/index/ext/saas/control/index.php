<?php
class index extends control
{
    public function __construct()
    {
        parent::__construct();
        $this->app->loadLang('user');
		$this->app->loadLang('pms');
    }

    public function index()
    {
        if($this->get->u)
        {
            $this->loadModel('referer')->saveReferer();
            $this->referer->saveIP();
        }
        $articles    = $this->loadModel('article')->getModuleArticle($this->config->saas->news->module);
        $newArticles = array();

        $i = 0;
        foreach($articles as $id => $article)
        {
            $newArticles[$id] = $article;
            $i++;
        }

		$this->loadModel('user');
        $this->view->header->title = $this->session->site->slogan;
        $this->view->layouts       = $this->loadModel('block')->getLayouts('index.index');
        $this->view->cases         = $this->dao->select('*')->from(TABLE_PMSSITE)->orderBy('id_desc')->limit(10)->fetchAll('', false);
        $this->view->articles      = $newArticles;
        $this->display();
    }
}
