<?php
class index extends control
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->header->title = $this->session->site->slogan;
        $this->view->modules       = $this->loadModel('guide')->getModules();
        $this->view->stickyGuides  = $this->guide->getStickyGuides($stickyLevel = 1);
        $this->view->latestGuides  = $this->guide->getLatestGuides(20);
        $this->view->layouts       = $this->loadModel('block')->getLayouts('index.index');
        $this->display();
    }
}
