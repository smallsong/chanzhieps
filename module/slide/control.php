<?php
/**
 * The control file of slide module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     slide
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class slide extends control
{
    /**
     * Browse slides in admin.
     * 
     * @access public
     * @return void
     */
    public function admin()
    {
        $this->view->slides = $this->slide->getList();
        $this->display();
    }

    /**
     * Create a slide.
     *
     * @access public 
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            if($this->slide->create())
            {
                $this->send(array('result' => 'success', 'message' => $this->lang->slide->successSave));
            }

            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }

        $this->display(); 
    }

    /**
     * Edit a slide.
     *
     * @access public
     * @return void
     */
    public function edit()
    {
        if($_POST)
        {
            if($this->slide->update()) $this->send(array('result' => 'success', 'message' => $this->lang->slide->successSave));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }

        $slide = $this->dao->select('*')->from(TABLE_CONFIG)->where('id')->eq($this->get->id)->fetch();

        $this->view->id   = $slide->id;
        $this->view->slide = json_decode($slide->value);
        $this->display();
    }

    /**
     * Delete a slide.
     *
     * @param int $id
     * @retturn void
     */
    public function delete($id)
    {
        $this->dao->delete()->from(TABLE_CONFIG)
            ->where('id')->eq($id)
            ->exec();

        if(!dao::isError()) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Sort slides.
     *
     * @access public
     * @return void
     */
    public function sort()
    {
        if($this->slide->sort()) $this->send(array('result' => 'success', 'message' => $this->lang->slide->successSort));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
}
