<?php
/**
 * The control file of thread category of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class thread extends control
{
    public function browse()
    {
    }

    public function browseAdmin($boardID = 0, $orderBy = 'lastRepliedDate_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        /* init pager. */ 
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $boards  = $this->loadModel('tree')->getAllChildID($boardID, 'forum');
        $threads = $boards ? $this->thread->getList($boards, $orderBy, $pager) : array();

        $this->view->threads       = $threads;
        $this->view->board         = $this->loadModel('tree')->getById($boardID);
        $this->view->pager         = $pager;
        $this->view->header->title = $this->view->board ? $this->view->board->name : '';
        $this->display();
    }
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
            $locate = js::locate($this->createLink('forum', 'board', "categoryID=$categoryID"), 'parent');
            $this->send(array(
            'resault' => 'success', 
            'message' => $this->lang->saveSuccess, 
            'locate' => $locate));
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
            $recTotal   = $_POST['recTotal']+1;
            $recPerPage = $_POST['recPerPage'];
            $pageID     = $_POST['pageID'];
            $replyID    = $this->thread->reply($threadID);
            $thread     = $this->thread->getByID($threadID);
            $this->thread->setCookie($replyID);
            if(dao::isError()) die(js::error(dao::getError()));
            $this->loadModel('message')->send($thread->author, sprintf($this->lang->thread->message, $this->app->user->account, count($thread->replies), $thread->title, $this->post->content), $this->createLink('thread', 'view', "thread=$threadID&recTotal=$recTotal&recPerPage=$recPerPage&pageTotal=$pageID"));
            die(js::locate(inlink('view', "thread=$threadID&recTotal=$recTotal&recPerPage=$recPerPage&pageTotal=$pageID"), 'parent'));
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
        $this->view->header->title = $this->view->thread->title . '|' . $this->view->board->name;
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
        $this->view->header->title = $this->view->thread->title . '|' . $this->view->board->name;
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
        $this->view->header->title = $this->view->thread->title . '|' . $this->view->board->name;
        $this->dao->update(TABLE_THREAD)->set('views = views + 1')->where('id')->eq($threadID)->exec();
        $this->display();
    }

    /**
     * Delete a thread.
     * 
     * @param string $threadID 
     * @param string $confirm 
     * @access public
     * @return void
     */
    public function deleteThread($threadID, $confirm = 'no')
    {
        $owners = $this->thread->getBoardOwners($threadID);
        if(!$this->thread->hasManagePriv($this->session->user->account, $owners)) exit;

        if($confirm == 'no')
        {
            echo js::confirm($this->lang->thread->confirmDeleteThread, inlink('deleteThread', "threadID=$threadID&confirm=yes"));
            exit;
        }
        else
        {
            $category = $this->dao->findById($threadID)->from(TABLE_THREAD)->fields('category')->fetch('category', false);
            $this->thread->deleteThread($threadID);
            die(js::locate($this->createLink('forum', 'board', "boardID=$category"), 'parent'));
        }
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
    public function deleteReply($replyID, $confirm = 'no')
    {
        $thread = $this->dao->findById($replyID)->from(TABLE_REPLY)->fields('thread')->fetch('thread');
        $owners = $this->thread->getBoardOwners($thread);

        if(!$this->thread->hasManagePriv($this->session->user->account, $owners)) die();
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->thread->confirmDeleteReply, inlink('deleteReply', "replyID=$replyID&confirm=yes"));
            exit;
        }
        else
        {
            $this->thread->deleteReply($replyID);
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
        $owners = $this->thread->getBoardOwners($threadID);

        if(!$this->thread->hasManagePriv($this->session->user->account, $owners)) die();
        $this->dao->update(TABLE_THREAD)->set('stick')->eq($stick)->where('id')->eq($threadID)->exec();
        die(js::reload('parent'));
    }

    /**
     * Convert ubb code to html.
     * 
     * @access public
     * @return void
     */
    public function convertUBB()
    {
        $threads = $this->dao->select('id, content')->from(TABLE_THREAD)->fetchPairs();
        $replies = $this->dao->select('id, content')->from(TABLE_REPLY)->fetchPairs();
        echo "converting thread ...";
        foreach($threads as $threadID => $threadContent)
        {
            echo $threadID . " ";
            $threadContent = html::ubb2html($threadContent);
            $threadContent = str_replace(array('[p]', '[/p]'), array('<p>', '</p>'), $threadContent);
            $this->dao->update(TABLE_THREAD)->set('content')->eq($threadContent)->where('id')->eq($threadID)->exec();
        }
        echo "<br />converting reply ...";
        foreach($replies as $replyID => $replyContent)
        {
            echo $replyID . " ";
            $replyContent = html::ubb2html($replyContent);
            $replyContent = str_replace(array('[p]', '[/p]'), array('<p>', '</p>'), $replyContent);
            $this->dao->update(TABLE_REPLY)->set('content')->eq($replyContent)->where('id')->eq($replyID)->exec();
        }
    }

    public function deleteFile($fileID, $objectID, $objectType, $confirm = 'no')
    {
        $table  = $objectType == 'thread' ? TABLE_THREAD : TABLE_REPLY;
        $object = $this->dao->findByID($objectID)->from($table)->fetch();
        if($this->session->user->account != $object->author) exit;

        if($confirm == 'no')
        {
            echo js::confirm($this->lang->thread->confirmDeleteFile, inlink('deleteFile', "fileID=$fileID&objectID=$objectID&objectType=$objectType&confirm=yes"));
            exit;
        }
        else
        {
            $this->loadModel('file')->delete($fileID);
            die(js::locate($this->createLink('thread', "edit$objectType", "threadID=$objectID"), 'parent'));
        }
    }
}
