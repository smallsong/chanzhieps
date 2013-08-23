<?php
/**
 * The model file of thread module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class threadModel extends model
{
    /**
     * Get a thread by id.
     * 
     * @param int    $threadID 
     * @param object $pager 
     * @access public
     * @return object
     */
    public function getById($threadID, $pager = null)
    {
        $thread = $this->dao->findById($threadID)->from(TABLE_THREAD)->fetch();
        if(!$thread) return false;

        $thread->files = $this->loadModel('file')->getByObject('thread', $thread->id);
        return $thread;
    }

    /**
     * Get threads list.
     * 
     * @param string $board      the boards
     * @param string $orderBy    the order by 
     * @param string $pager      the pager object
     * @access public
     * @return array
     */
    public function getList($board, $orderBy, $pager = null)
    {
        $threads = $this->dao->select('*')->from(TABLE_THREAD)
            ->where('board')->in($board)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
        if(!$threads) return array();

        return $this->process($threads);
    }

    /**
     * Get stick threads.
     * 
     * @param  int    $board 
     * @access public
     * @return array
     */
    public function getSticks($board)
    {
        $globalSticks = $this->dao->select('*')->from(TABLE_THREAD)->where('stick')->eq(2)->orderBy('id desc')->fetchAll();
        $boardSticks  = $this->dao->select('*')->from(TABLE_THREAD)->where('stick')->eq(1)->andWhere('board')->eq($board)->orderBy('id desc')->fetchAll();

        return array_merge($globalSticks, $boardSticks);
    }

    /**
     * Get threads of a user.
     * 
     * @param string $account       the account
     * @param string $pager         the pager object
     * @access public
     * @return array
     */
    public function getByUser($account, $pager)
    {
        $threads = $this->dao->select('*')
            ->from(TABLE_THREAD)
            ->where('author')->eq($account)
            ->orderBy('repliedDate desc')
            ->page($pager)
            ->fetchAll('id');
        return $this->process($threads);
    }

    /**
     * Process threads.
     * 
     * @param  array    $threads 
     * @access public
     * @return array
     */
    public function process($threads)
    {
        foreach($threads as $thread)
        {
            /* Hide the thread or not. */
            if($thread->hidden and strpos($this->cookie->t, ",$thread->id,") === false) unset($threads[$thread->id]);

            /* Judge the thread is new or not.*/
            $thread->isNew = (time() - strtotime($thread->repliedDate)) < 24 * 60 * 60 * $this->config->thread->newDays;
        }

        return $threads;
    }

    /**
     * Post a thread.
     * 
     * @param  int      $board 
     * @access public
     * @return void
     */
    public function post($board)
    {
        $now = helper::now();
        $thread = fixer::input('post')
            ->specialChars('title')
            ->stripTags('content', $this->config->thread->editor->allowTags)
            ->add('board', $board)
            ->add('author', $this->app->user->account)
            ->add('addedDate', $now) 
            ->add('repliedDate', $now)
            ->remove('files, labels')
            ->get();

        $this->dao->insert(TABLE_THREAD)->data($thread)->autoCheck()->batchCheck('title, content', 'notempty')->exec();

        if(!dao::isError())
        {
            $threadID = $this->dao->lastInsertID();
            $this->saveCookie($threadID);
            $this->loadModel('file')->saveUpload('thread', $threadID);

            /* Update board stats. */
            $thread->threadID = $threadID;
            $thread->replyID  = 0;
            $this->loadModel('forum')->updateBoardStats($board, 'thread', $thread);

            return $threadID;
        }

        return false;
    }

    /**
     * Save the thread id to cookie.
     * 
     * @param  int     $thread 
     * @access public
     * @return void
     */
    public function saveCookie($thread)
    {
        $thread = "$thread,";
        $cookie = $this->cookie->t != false ? $this->cookie->t : ',';
        if(strpos($cookie, $thread) === false) $cookie .= $thread;
        setcookie('t', $cookie , time() + 60 * 60 * 24 * 30);
    }

    /**
     * Update thread.
     * 
     * @param  int    $threadID 
     * @access public
     * @return void
     */
    public function update($threadID)
    {
        $thread = fixer::input('post')
            ->add('editor', $this->session->user->account)
            ->add('editedDate', helper::now())
            ->stripTags('content', $this->config->thread->editor->allowTags)
            ->remove('files,labels')
            ->get();

        $this->dao->update(TABLE_THREAD)
            ->data($thread)
            ->autoCheck()
            ->batchCheck('title, content', 'notempty')
            ->where('id')->eq($threadID)
            ->exec();

        if(dao::isError()) return false;

        /* Upload file.*/
        $this->loadModel('file')->saveUpload('thread', $threadID);

        return true;
    }

    /**
     * Delete a thread.
     * 
     * @param string $threadID 
     * @access public
     * @return void
     */
    public function delete($threadID , $null = null)
    {
        $this->dao->delete()->from(TABLE_THREAD)->where('id')->eq($threadID)->exec(false);
        $this->dao->delete()->from(TABLE_REPLY)->where('thread')->eq($threadID)->exec(false);
        return !dao::isError();
    }

    /**
     * Hide a thread.
     * 
     * @param  int    $threadID 
     * @access public
     * @return void
     */
    public function hide($threadID)
    {
        $this->dao->update(TABLE_THREAD)->set('hidden')->eq(1)->where('id')->eq($threadID)->exec();
        return !dao::isError();
    }

    /**
     * Print files of for a thread.
     * 
     * @param  object $thread 
     * @param  bool   $canManage 
     * @access public
     * @return void
     */
    public function printFiles($thread, $canManage)
    {
        if(empty($thread->files)) return false;

        echo $this->lang->thread->file;
        foreach($thread->files as $file)
        {
            $file->title .= ".$file->extension";
            echo html::a(helper::createLink('file', 'download', "fileID=$file->id&mouse=left"), $file->title, '_blank'); 
            if($canManage) echo '<sub>' . html::a(inlink('deleteFile', "threadID=$thread->id&fileID=$file->id"), '[x]', '', "class='deleter'") . '</sub>';
            echo ' ';
        }
    }

    /**
     * Set the views counter + 1;
     * 
     * @param  int    $thread 
     * @access public
     * @return void
     */
    public function plusCounter($thread)
    {
        $this->dao->update(TABLE_THREAD)->set('views = views + 1')->where('id')->eq($thread)->exec();
    }

    /**
     * Get all speakers of one thread.
     * 
     * @param  object   $thread 
     * @param  array    $replies 
     * @access public
     * @return array
     */
    public function getSpeakers($thread, $replies)
    {
        $speakers = array();
        $speakers[$thread->author] = $thread->author;
        if(!$replies) return $speakers;

        foreach($replies as $reply) $speakers[$reply->author] = $reply->author;
        return $speakers;
    }

    /**
     * Can the user edit a thread or not.
     * 
     * @param boject $board    the board.
     * @param string $author   the author of the thread
     * @access public
     * @return void
     */
    public function canEdit($board, $author)
    {
        /* If the board is readonly, only managers can edit it. */
        if(isset($board->readonly) && $board->readonly) return $this->canManage($board);

        /* If the board is an open one, the author or managers can edit it. */
        $user = $this->app->user->account;
        if($user == $author) return true;

        if(isset($board->moderators) && $this->canManage($board->moderators)) return true;

        return $this->canManage($board);
    }

    /**
     * Judge the user can manage current thread nor not.
     * 
     * @param  string $moderators 
     * @access public
     * @return array
     */
    public function canManage($moderators)
    {
        /* First check the user is admin or not. */
        if($this->app->user->admin == 'super') return true; 

        /* Then check the user is a moderator or not. */
        $user = ",{$this->app->user->account},";
        $moderators = ',' . str_replace(' ', '', $moderators) . ',';
        if(strpos($moderators, $user) !== false) return true;

        return false;
    }

    /**
     * Set editor tools for current user. 
     * 
     * @param  string    $moderators 
     * @access public
     * @return void
     */
    public function setEditor($moderators, $page)
    {
        if($this->canManage($moderators))
        {
            $this->config->thread->editor->{$page}['tools'] = 'fullTools';
        }
    }

    /**
     * Get the moderators of one board.
     * 
     * @param string $thread 
     * @access public
     * @return string
     */
    public function getModerators($thread)
    {
        return $this->dao->select('moderators')
            ->from(TABLE_CATEGORY)->alias('t1')
            ->leftJoin(TABLE_THREAD)->alias('t2')->on('t1.id = t2.board')
            ->where('t2.id')->eq($thread)
            ->fetch('moderators');
    }
}
