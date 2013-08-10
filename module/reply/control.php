<?php
/**
 * The control file of reply module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     reply
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class reply extends control
{
    /**
     * Reply a thread.
     * 
     * @param  int      $threadID 
     * @access public
     * @return void
     */
    public function post($threadID)
    {
        if($this->app->user->account == 'guest') die(js::locate($this->createLink('user', 'login')));

        if($_POST)
        {
            $replyID = $this->reply->post($threadID);

            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'locate' => $this->createLink('thread', 'view', "threadID=$threadID")));
        }
    }

    /**
     * Edit a reply.
     * 
     * @param string $replyID 
     * @access public
     * @return void
     */
    public function edit($replyID)
    {
        if($this->app->user->account == 'guest') die(js::locate($this->createLink('user', 'login')));

        /* Judge current user has priviledge to edit the reply or not. */
        $reply = $this->reply->getByID($replyID);
        if(!$reply) die(js::locate('back'));

        $moderators = $this->loadModel('thread')->getModerators($reply->thread);
        if(!$this->thread->canEdit($moderators, $reply->author)) die(js::locate('back'));

        $thread = $this->thread->getByID($reply->thread);
        
        if($_POST)
        {
            $this->reply->update($replyID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->send(array('result' => 'success', 'locate' => $this->createLink('thread', 'view', "threaID=$thread->id")));
        }

        $this->view->title  = $this->lang->reply->edit . $this->lang->colon . $thread->title;
        $this->view->reply  = $reply;
        $this->view->thread = $thread;
        $this->view->board  = $this->loadModel('tree')->getById($thread->board);

        $this->display();
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
        $owners = $this->thread->getBoardOwners($thread);

        if(!$this->thread->hasManagePriv($this->session->user->account, $owners)) die();
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
     * delete a file from object.
     *
     * @param int    $fileID
     * @param int    $objectID
     * @param string $objectType
     *
     */
    public function deleteFile($fileID, $objectID, $objectType)
    {
        $table  = $objectType == 'thread' ? TABLE_THREAD : TABLE_REPLY;
        $object = $this->dao->findByID($objectID)->from($table)->fetch();
        if($this->session->user->account != $object->author) exit;

        if($this->loadModel('file')->delete($fileID)) $this->send(array('result'=>'success'));
        $this->send(array('result'=>'fail', 'message'=> dao::getError()));
    }
}
