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
     * @param int $categoryID 
     * @access public
     * @return void
     */
    public function post($categoryID = 0)
    {
        if($this->app->user->account == 'guest') die(js::locate($this->createLink('user', 'login')));

        $board = $this->loadModel('tree')->getById($categoryID);
        if($board->readonly)
        {
            $this->app->loadLang('forum');
            echo js::error($this->lang->forum->readonly);
            die(js::locate('back'));
        }

        if($_POST)
        {
            $result = $this->thread->post($categoryID);
            if(dao::isError()) $this->send(array('result' =>'fail', 'message' => dao::getError()));
            $locate = $this->createLink('forum', 'board', "categoryID=$categoryID");
            $this->send(array(
            'result' => 'success', 
            'message' => $this->lang->saveSuccess, 
            'locate' =>$locate));
        }
        $this->view->board = $board;
        $this->view->tree  = $this->tree->getOptionMenu('thread');
        $this->display();
    }

    /**
     * Reply a thread.
     * 
     * @param string $threadID 
     * @access public
     * @return void
     */
    public function reply($threadID, $repliedUser = '')
    {
        if($this->app->user->account == 'guest') die(js::locate($this->createLink('user', 'login')));
        if($_POST)
        {
            $replyID = $this->thread->reply($threadID);
            if(!dao::isError()) $this->send(array('result' => 'success', 'locate' => inlink('view', "threadID=$threadID")));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $thread     = $this->thread->getById($threadID);
            $this->thread->setCookie($replyID);
        }
    }

    /**
     * Edit a thread.
     * 
     * @param string $threadID 
     * @access public
     * @return void
     */
    public function editThread($threadID)
    {
        /* Judge current user has priviledge to edit the thread or not. */
        $thread = $this->dao->findById($threadID)->from(TABLE_THREAD)->fields('author, category')->fetch();
        if(!$thread) exit;
        $owners = $this->dao->findById($thread->category)->from(TABLE_CATEGORY)->fields('owners')->fetch('owners');
        if(!$this->thread->hasEditPriv($this->session->user->account, $owners, $thread->author)) exit;
        $thread->files = $this->loadModel('file')->getByObject('thread', $threadID);

        if($_POST)
        {
            $this->thread->updateThread($threadID);
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate(inlink('view', "threaID=$threadID"), 'parent'));
        }
        $this->view->thread = $this->thread->getById($threadID);
        $this->view->board  = $this->loadModel('tree')->getById($this->view->thread->category);
        $this->view->title = $this->view->thread->title . '|' . $this->view->board->name;
        $this->display();
    }

    /**
     * Edit a reply.
     * 
     * @param string $replyID 
     * @access public
     * @return void
     */
    public function editReply($replyID)
    {
        /* Judge current user has priviledge to edit the reply or not. */
        $reply = $this->dao->findById($replyID)->from(TABLE_REPLY)->fetch();
        if(!$reply) exit;
        $owners = $this->thread->getBoardOwners($reply->thread);
        
        if(!$this->thread->hasEditPriv($this->session->user->account, $owners, $reply->author)) exit;

        if($_POST)
        {
            if($this->loadModel('comment')->isGarbage($_POST['content'])) die();
            $this->thread->updateReply($replyID);
            $threadID = $this->dao->findById($replyID)->from(TABLE_REPLY)->fields('thread')->fetch('thread');
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate(inlink('view', "threaID=$threadID"), 'parent'));
        }
        $reply->files       = $this->loadModel('file')->getByObject('reply', $replyID);
        $this->view->reply  = $reply;
        $this->view->thread = $this->thread->getByID($this->view->reply->thread);
        $this->view->board  = $this->loadModel('tree')->getById($this->view->thread->category);
        $this->view->title = $this->view->thread->title . '|' . $this->view->board->name;
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
    public function view($threadID, $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $this->view->thread = $this->thread->getByID($threadID, $pager);
        $this->view->pager  = $pager;
        $this->view->users  = $this->loadModel('user')->getBasicInfo($this->thread->extractUsers($this->view->thread));
        $this->view->board  = $this->loadModel('tree')->getById($this->view->thread->category);
        $this->view->layouts= $this->loadModel('block')->getLayouts('thread.view');
        $this->view->title = $this->view->thread->title . '|' . $this->view->board->name;
        $this->dao->update(TABLE_THREAD)->set('views = views + 1')->where('id')->eq($threadID)->exec();
        $this->display();
    }

    /**
     * Delete a thread.
     * 
     * @param string $threadID 
     * @access public
     * @return void
     */
    public function delete($threadID)
    {
        $owners = $this->thread->getBoardOwners($threadID);
        if(!$this->thread->hasManagePriv($this->session->user->account, $owners)) $this->send(array('result' => 'fail'));

        $category = $this->dao->findById($threadID)->from(TABLE_THREAD)->fields('category')->fetch('category', false);
        $result   = $this->thread->deleteThread($threadID);
        
        if($result) $this->send(array('result' => 'success'));
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
    public function hidePost($objectType, $objectID, $confirm = 'no')
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
     * Delete a reply 
     * 
     * @param string $replyID 
     * @param string $confirm 
     * @access public
     * @return void
     */
    public function deleteReply($replyID)
    {
        $thread = $this->dao->findById($replyID)->from(TABLE_REPLY)->fields('thread')->fetch('thread');
        $owners = $this->thread->getBoardOwners($thread);

        if(!$this->thread->hasManagePriv($this->session->user->account, $owners)) $this->send(array('result' => 'fail'));

        $result = $this->thread->deleteReply($replyID);
        if($result) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
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
        $owners = $this->thread->getBoardOwners($threadID);

        if(!$this->thread->hasManagePriv($this->session->user->account, $owners)) die();
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
    public function deleteFile($fileID, $objectID, $objectType)
    {
        $table  = $objectType == 'thread' ? TABLE_THREAD : TABLE_REPLY;
        $object = $this->dao->findByID($objectID)->from($table)->fetch();
        if($this->session->user->account != $object->author) exit;

        if($this->loadModel('file')->delete($fileID)) $this->send(array('result'=>'success'));
        $this->send(array('result'=>'fail', 'message'=> dao::getError()));
    }
}
