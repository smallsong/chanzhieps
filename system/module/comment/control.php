<?php
/**
 * The control file of comment module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     comment
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class comment extends control
{
    /**
     * Show the comments of one object, and print the comment form.
     * 
     * @param string $objectType 
     * @param string $objectID 
     * @access public
     * @return void
     */
    public function show($objectType, $objectID, $recTotal = 0, $recPerPage = 10, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->view->objectType = $objectType;
        $this->view->objectID   = $objectID;
        $this->view->comments   = $this->comment->getByObject($objectType, $objectID, $pager);
        $this->view->pager      = $pager;
        $this->display();
    }

    /**
     * Post a comment.
     * 
     * @access public
     * @return void
     */
    public function post()
    {
        if($_POST)
        {
            /* If no captcha but is garbage, return the error info. */
            if($this->post->captcha == false and $this->loadModel('captcha')->isEvil($this->post->content))
            {
                $this->send(array('result' => 'fail', 'reason' => 'needChecking', 'captcha' => $this->captcha->create4Comment()));
            }

            /* Try to save to database. */
            $commentID = $this->comment->post();

            /* If save fail, return the error info. */
            if(!$commentID)
            {
                $this->send(array('result' => 'fail', 'reason' => 'error', 'message' => dao::getError()));
            }

            /* If save successfully, save the cookie and send success info. */
            $this->comment->setCookie($commentID);
            $this->send(array('result' => 'success', 'message' => $this->lang->comment->thanks));
        }
    }

    /**
     * Get the latest approvaled comments.
     * 
     * @param int    $status 
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function admin($status = '0', $recTotal = 0, $recPerPage = 5, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->view->comments    = $this->comment->getList($status, $pager);
        $this->view->pager       = $pager;
        $this->view->status      = $status;
        $this->view->currentMenu = $status == 0 ? 0 : 1;
        $this->display();
    }

    /** 
     * Delete comments.
     *
     * @param int    $commentID 
     * @param string $type          single|pre
     * @access public
     * @return void
     */
    public function delete($commentID, $type, $status = 0)
    {
        $this->comment->delete($commentID, $type);
        if(!dao::isError()) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Pass comments.
     * 
     * @param  int    $commentID 
     * @param  string $type 
     * @access public
     * @return void
     */
    public function pass($commentID, $type)
    {
        $this->comment->pass($commentID, $type);
        if(!dao::isError()) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
}
