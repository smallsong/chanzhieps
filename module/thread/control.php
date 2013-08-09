<?php
/**
 * The control file of thread category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class thread extends control
{
    /** 
     * Post a thread.
     * 
     * @param  int      $boardID 
     * @access public
     * @return void
     */
    public function post($boardID = 0)
    {
        if($this->app->user->account == 'guest') die(js::locate($this->createLink('user', 'login')));

        /* Get the board. */
        $board = $this->loadModel('tree')->getById($boardID);

        /* Checking current user can post to the board or not. */
        if(!$this->loadModel('forum')->canPost($board))
        {
            $this->app->loadLang('forum');
            die(js::error($this->lang->forum->readonly) . js::locate('back'));
        }

        /* Set editor for current user. */
        $this->thread->setEditor($board->moderators, 'post');

        /* User posted a thread, try to save it to database. */
        if($_POST)
        {
            $result = $this->thread->post($boardID);
            if(dao::isError()) $this->send(array('result' =>'fail', 'message' => dao::getError()));

            $locate = $this->createLink('forum', 'board', "boardID=$boardID");
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' =>$locate));
        }

        $this->view->title = $board->name . $this->lang->thread->post;
        $this->view->board = $board;
        $this->display();
    }

    /**
     * Edit a thread.
     * 
     * @param string $threadID 
     * @access public
     * @return void
     */
    public function edit($threadID)
    {
        $thread = $this->thread->getByID($threadID);
        if(!$thread) die(js::locate('back'));

        /* Judge current user has priviledge to edit the thread or not. */
        $moderators = $this->thread->getModerators($threadID);
        if(!$this->thread->canEdit($moderators, $thread->author)) die(js::locate('back'));

        if($_POST)
        {
            $this->thread->update($threadID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'locate' => inlink('view', "threadID=$threadID")));
        }

        $this->view->title  = $this->lang->thread->edit . $this->view->thread->title;
        $this->view->thread = $thread;
        $this->view->board  = $this->loadModel('tree')->getById($thread->board);

        $this->display();
    }

    /**
     * View a thread.
     * 
     * @param  int    $threadID 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function view($threadID, $recTotal = 0, $recPerPage = 10, $pageID = 1)
    {
        $thread = $this->thread->getByID($threadID);
        if(!$thread) die(js::locate('back'));

        /* Get thread board. */
        $board = $this->loadModel('tree')->getById($thread->board);

        /* Get replies. */
        $this->app->loadClass('pager', $static = true);
        $pager   = new pager($recTotal, $recPerPage, $pageID);
        $replies = $this->loadModel('reply')->getByThread($threadID, $pager);

        /* Get all speakers. */
        $speakers = $this->thread->getSpeakers($thread, $replies);

        $this->view->title    = $thread->title . '-' . $board->name;
        $this->view->board    = $board;
        $this->view->thread   = $thread;
        $this->view->replies  = $replies;
        $this->view->pager    = $pager;
        $this->view->speakers = $this->loadModel('user')->getBasicInfo($speakers);
        //$this->view->layouts= $this->loadModel('block')->getLayouts('thread.view');
        $this->display();
    }

    /**
     * Delete a thread.
     * 
     * @param  int      $threadID 
     * @access public
     * @return void
     */
    public function delete($threadID)
    {
        $moderators = $this->thread->getModerators($threadID);
        if(!$this->thread->canManage($moderators)) $this->send(array('result' => 'fail'));

        if($this->thread->delete($threadID)) $this->send(array('result' => 'success'));

        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
   
    /**
     * Hide a reply.
     * 
     * @param  string $replyID 
     * @param  string $confirm 
     * @access public
     * @return void
     */
    public function hide($objectType, $objectID, $confirm = 'no')
    {
        $thread = $objectType == 'reply' ? $this->dao->findById($objectID)->from(TABLE_REPLY)->fields('thread')->fetch('thread') : $objectID;
        $moderators = $this->thread->getBoardOwners($thread);

        if(!$this->thread->hasManagePriv($this->session->user->account, $moderators)) die();
        if($confirm == 'no')
        {
            $hideType = "confirmHide" . ucfirst($objectType);
            echo js::confirm($this->lang->thread->$hideType, inlink('hidePost', "objectType=$objectType&objectID=$objectID&confirm=yes"));
            exit;
        }
        else
        {
            $funcName = 'hide' . ucfirst($objectType);
            $this->thread->$funcName($objectID);
            die(js::reload('parent'));
        }
    }

    /**
     * Set the stick level of a thread.
     * 
     * @param  int    $threadID 
     * @param  int    $stick 
     * @access public
     * @return void
     */
    public function stick($threadID, $stick)
    {
        $moderators = $this->thread->getModerators($threadID);
        if(!$this->thread->canManage($moderators)) die();

        $this->dao->update(TABLE_THREAD)->set('stick')->eq($stick)->where('id')->eq($threadID)->exec();
        if(dao::isError()) $this->send(array('result' =>'fail', 'message' => dao::getError()));
        $this->send(array('message' => $this->lang->thread->successStick, 'target' => '#manageBox', 'source' => inlink('view', "threaID=$threadID") . ' #manageMenu'));
    }

    /**
     * delete a file from object.
     *
     * @param int    $fileID
     * @param int    $objectID
     * @param string $objectType
     *
     */
    public function deleteFile($fileID)
    {
        $table  = $objectType == 'thread' ? TABLE_THREAD : TABLE_REPLY;
        $object = $this->dao->findByID($objectID)->from($table)->fetch();
        if($this->session->user->account != $object->author) exit;

        if($this->loadModel('file')->delete($fileID)) $this->send(array('result'=>'success'));
        $this->send(array('result'=>'fail', 'message'=> dao::getError()));
    }
}
