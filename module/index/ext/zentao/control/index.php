<?php
class index extends control
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->loadModel('article');
        $this->app->loadLang('user');
        if($this->get->u)
        {
            $this->loadModel('referer')->saveReferer();
            $this->referer->saveIP();
        }
        $moduleID = $this->cookie->lang == 'zh-cn' ? '1072,1067' : '1279,1280';
        $this->view->articles   = $this->dao->select('*')->from(TABLE_ARTICLE)->alias('t1')
            ->leftJoin(TABLE_ARTICLEMODULE)->alias('t2')->on('t1.id = t2.article')
            ->where('t2.module')->in($moduleID)
            ->orderBy('t1.id desc')->limit($this->config->zentao->limitNum)->fetchAll('id', false);
        $this->view->header->title = $this->lang->index->title;
        $this->view->layouts       = $this->loadModel('block')->getLayouts('index.index');
        $this->display();
    }
}
