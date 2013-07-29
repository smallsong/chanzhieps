<?php
/**
 * The model file of thread category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
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
        $userReplies  = $this->cookie->rps;
        $thread = $this->dao->findById($threadID)->from(TABLE_THREAD)->fetch('', false);
        $thread->replies = $this->dao->select('*')->from(TABLE_REPLY)
            ->where('thread')->eq($threadID)
            ->andWhere("(INSTR('$userReplies', CONCAT('_',id,'_')) != 0 or hidden != '1' or author = '{$this->app->user->account}')") //exclude hide.
            ->orderBy('id')->page($pager, false)->fetchAll('id', false);
        $thread->files   = $this->loadModel('file')->getByObject('thread', $thread->id);

        if($thread->replies == true)
        {
            $replyFiles = $this->file->getByObject('reply', array_keys($thread->replies));

            foreach($replyFiles as $fileID => $replyFile) $thread->replies[$replyFile->objectID]->files[$fileID] = $replyFile;
        }
        return $thread;
    }

    /**
     * Get threads list.
     * 
     * @param int    $category      the category
     * @param string $orderBy       the order by 
     * @param string $pager         the pager object
     * @access public
     * @return array
     */
    public function getList($category, $orderBy, $pager = null)
    {
        $userThreads = $this->cookie->threads;
        $threads = $this->dao->select('*')->from(TABLE_THREAD)
            ->where('category')->in($category)
            ->andWhere("(INSTR('$userThreads', CONCAT('_',id,'_')) != 0 or hidden != 1 or author = '{$this->app->user->account}')") //exclude hide.
            ->orderBy($orderBy)->page($pager, false)->fetchAll('id', false);
        $this->processThreads($threads);
        return $threads;
    }

    /**
     * Get stick threads.
     * 
     * @param  int    $category 
     * @access public
     * @return array
     */
    public function getSticks($category)
    {
        $globalSticks = $this->dao->select('*')->from(TABLE_THREAD)->where('stick')->eq(2)->orderBy('id desc')->fetchAll();
        $boardSticks  = $this->dao->select('*')->from(TABLE_THREAD)->where('stick')->eq(1)->andWhere('category')->eq($category)->orderBy('id desc')->fetchAll();

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
        $threads = $this->dao->select('*')->from(TABLE_THREAD)->where('author')->eq($account)->orderBy('lastRepliedDate desc')->page($pager)->fetchAll('id');
        $this->processThreads($threads);
        return $threads;
    }

    /**
     * Get replies of a user.
     * 
     * @param string $account       the account
     * @param string $pager         the pager object
     * @access public
     * @return array
     */
    public function getReplyByUser($account, $pager)
    {
        $replies = $this->dao->select('t1.*, t2.title')->from(TABLE_REPLY)->alias('t1')
            ->leftJoin(TABLE_THREAD)->alias('t2')->on('t1.thread = t2.id')
            ->where('t1.author')->eq($account)
            ->orderBy('t1.id desc')
            ->page($pager)
            ->fetchAll('id');
        return $replies;
    }

    /**
     * Get the owners of one board.
     * 
     * @param string $thread 
     * @access public
     * @return string
     */
    public function getBoardOwners($thread)
    {
        $owners = $this->dao->select('owners')
            ->from(TABLE_CATEGORY)->alias('t1')->leftJoin(TABLE_THREAD)->alias('t2')->on('t1.id = t2.category')
            ->where('t2.id')->eq($thread)
            ->fetch('owners');
        return $owners;
    }

    public function checkBlacklist($thread)
    {
        $blacklists = $this->config->thread->blacklist;
        $ip         = $this->loadModel('common')->getIP();

        if(in_array($ip, $blacklists['ip'])) return true;

        foreach($blacklists['keyword'] as $keywordBlacklist)
        {
            if(isset($thread->title) and strpos($thread->title, $keywordBlacklist) !== false) return true;
            if(strpos($thread->content, $keywordBlacklist) !== false) return true;
        }

        unset($blacklists['ip']);
        unset($blacklists['keyword']);

        foreach($blacklists as $key => $blacklist)
        {
            if(in_array($this->app->user->$key,$blacklist)) return true;
        }

        return false;
    }

    /**
     * Post a thread.
     * 
     * @param string $category 
     * @access public
     * @return void
     */
    public function post($category)
    {
        $thread = fixer::input('post')
            ->specialChars('title')
            ->add('author', $this->app->user->account)
            ->add('addedDate', helper::now())
            ->add('lastRepliedDate', helper::now())
            ->add('category', $category)
            ->stripTags('content', $this->config->thread->editor->allowableTags)
            ->remove('files,labels')
            ->get();
        /* Stop for blacklist. */
        if($this->checkBlacklist($thread)) die();

        if(trim(strip_tags($thread->content) == '')) $thread->content = '';
        $this->dao->insert(TABLE_THREAD)->data($thread)->autoCheck()->batchCheck('title, content', 'notempty')->exec();

        if(!dao::isError())
        {
            $threadID = $this->dao->lastInsertID();
            /* set cookie in thread author.*/
            $this->setCookie($threadID, 'thread');
            /* Upload file.*/
            $this->uploadFile('thread', $threadID);

            $thread->threadID = $threadID;
            $thread->replyID  = 0;
            $this->loadModel('forum')->updateBoardStats($category, 'thread', $thread);
        }
        return;
    }

    /**
     * Reply a thread.
     * 
     * @param string $threadID 
     * @access public
     * @return void
     */
    public function reply($threadID)
    {
        $reply = fixer::input('post')
            ->add('author', $this->app->user->account)
            ->add('addedDate', helper::now())
            ->add('thread', $threadID)
            ->stripTags('content', $this->config->thread->editor->allowableTags)
            ->remove('yzm')
            ->remove('recTotal')
            ->remove('recPerPage')
            ->remove('pageID')
            ->remove('files,labels')
            ->get();

        if($this->loadModel('comment')->isGarbage($reply->content)) die();
        /* Stop for blacklist. */
        if($this->checkBlacklist($reply)) die();
        
        if(trim(strip_tags($reply->content)) == '') $reply->content = '';
        return $this->saveReply($threadID, $reply);
    }

    /**
     * Set user reply Cookie. 
     * 
     * @param  int $replyID 
     * @access public
     * @return void
     */
    public function setCookie($objectID, $objectType = 'reply')
    {
        $objectID   = '_' . $objectID . '_';
        $cookieName = $objectType == 'reply' ? 'rps' : 'threads';
        $objectIDs  =  $this->cookie->$cookieName;
        if(!$objectIDs)
        {
            $objectIDs = $objectID;
        }
        elseif(strpos($objectIDs, $objectID) === false)
        {
            $objectIDs .= $objectID;
        }
        setcookie($cookieName, $objectIDs, time() + 31104000);
    }

    /**
     * Update thread.
     * 
     * @param string $threadId 
     * @access public
     * @return void
     */
    public function updateThread($threadId)
    {
        $thread = fixer::input('post')
            ->add('editor', $this->session->user->account)
            ->add('editedDate', helper::now())
            ->stripTags('content', $this->config->thread->editor->allowableTags)
            ->remove('files,labels')
            ->get();

        /* Stop for blacklist. */
        if($this->checkBlacklist($thread)) die();

        $this->dao->update(TABLE_THREAD)->data($thread)->autoCheck()->batchCheck('title, content', 'notempty')->where('id')->eq($threadId)->exec();
        /* Upload file.*/
        $this->uploadFile('thread', $threadId);
        return;
    }

    /**
     * Update reply.
     * 
     * @param string $replyId 
     * @access public
     * @return void
     */
    public function updateReply($replyId)
    {
        $reply = fixer::input('post')
            ->add('editor', $this->session->user->account)
            ->add('editedDate', helper::now())
            ->stripTags('content', $this->config->thread->editor->allowableTags)
            ->remove('yzm,files,labels')
            ->get();
        $this->dao->update(TABLE_REPLY)->data($reply)->autoCheck()->check('content', 'notempty')->where('id')->eq($replyId)->exec();
        /* Upload file.*/
        $this->uploadFile('reply', $replyId);
        return;
    }

    /**
     * Delete a thread.
     * 
     * @param string $threadID 
     * @access public
     * @return void
     */
    public function deleteThread($threadID)
    {
        $this->dao->delete()->from(TABLE_THREAD)->where('id')->eq($threadID)->exec(false);
        $this->dao->delete()->from(TABLE_REPLY)->where('thread')->eq($threadID)->exec(false);
        return !dao::isError();
    }

    public function hideThread($threadID)
    {
        $this->dao->update(TABLE_THREAD)->set('hidden')->eq(1)->where('id')->eq($threadID)->exec();
    }
    /**
     * Hide a reply. 
     * 
     * @param  string $replyID 
     * @access public
     * @return void
     */
    public function hideReply($replyID)
    {
        $this->dao->update(TABLE_REPLY)->set('hidden')->eq(1)->where('id')->eq($replyID)->exec();
    }

    /**
     * Delete a reply.
     * 
     * @param string $replyID 
     * @access public
     * @return void
     */
    public function deleteReply($replyID)
    {
        $this->dao->delete()->from(TABLE_REPLY)->where('id')->eq($replyID)->exec(false);
        return !dao::isError();
    }

    /**
     * Judge wether has edit priviledge or not.
     * 
     * @param string $user          the user to judge
     * @param string $boardOwner    the owners of the board
     * @param string $author        the author of the thread
     * @access public
     * @return void
     */
    public function hasEditPriv($user, $boardOwner, $author)
    {
        if($this->app->user->admin == 'super' or strpos($boardOwner, $user) !== false) return true;
        return false;
    }

    /**
     * Judge wether has Manage priviledge or not.
     * 
     * @param  string $user 
     * @param  string $boardOwner 
     * @access public
     * @return array
     */
    public function hasManagePriv($user, $boardOwner)
    {
        if($this->app->user->admin == 'super' or strpos($boardOwner, $user) !== false) return true;
        return false;
    }

    /**
     * Extract users from thread.
     * 
     * @param  string $thread 
     * @access public
     * @return array
     */
    public function extractUsers($thread)
    {
        $users = array();
        $users[$thread->author] = $thread->author;
        if($thread->replies)
        {
            foreach($thread->replies as $reply) $users[$reply->author] = $reply->author;
        }
        return $users;
    }

    /**
     * Thread to ask 
     * 
     * @param int $threadID 
     * @param int $questionID 
     * @access public
     * @return void
     */
    public function toAsk($threadID, $questionID)
    {
        $thread = $this->getById($threadID);
        $reply->author = $this->app->user->account;
        $reply->addedDate = helper::now();
        $reply->thread = $threadID;
        $reply->content = sprintf($this->lang->reply->toAsk, $questionID);
        $this->saveReply($threadID, $reply);
        $this->dao->update(TABLE_THREAD)->set('readonly')->eq(1)->where('id')->eq($threadID)->exec(false);
        $this->loadModel('score')->punish($thread->author,'threadtoask', $this->config->score->counts->thread, 'thread', $threadID);
    }

    /**
     * Process threads 
     * 
     * @param  array $threads 
     * @access private
     * @return void
     */
    private function processThreads($threads)
    {
        $now = time();
        foreach($threads as $threadID => $thread)
        {
            $thread->isNew = ($now - strtotime($thread->lastRepliedDate)) < 24 * 60 * 60 * $this->config->thread->newDays;
        }
    }

    /**
     * Save reply 
     * 
     * @param int    $threadID 
     * @param string $reply 
     * @access private
     * @return int
     */
    private function saveReply($threadID, $reply)
    {
        $this->dao->insert(TABLE_REPLY)->data($reply)->autoCheck()->check('content', 'notempty')->exec();

        if(!dao::isError())
        {
            $replyID = $this->dao->lastInsertID();
            /* Upload file.*/
            $this->uploadFile('reply', $replyID);
            $thread = $this->dao->findById($threadID)->from(TABLE_THREAD)->fields('replies, category')->fetch();

            $thread->replies += 1;
            $thread->lastRepliedDate = helper::now();
            $thread->lastRepliedBy   = $this->app->user->account;
            $thread->lastReplyID     = $replyID;
            $this->dao->update(TABLE_THREAD)->data($thread)->where('id')->eq($threadID)->exec();

            $reply->threadID = $threadID;
            $reply->replyID  = $replyID;
            $this->loadModel('forum')->updateBoardStats($thread->category, 'reply', $reply);
        }

        return;
    }

    private function uploadFile($objectType, $objectID)
    {
        $files = $this->loadModel('file')->getUpload('files');
        if($files) $this->file->saveUpload($objectType, $objectID);
    }

    public function printFiles($objectID, $files, $type= 'reply', $managePriv = false)
    {
        if(empty($files)) return;
        echo '<br /><br />' . $this->lang->thread->file . ":";
        foreach($files as $file)
        {
            echo html::a(helper::createLink('file', 'download', "fileID=$file->id"), $file->title . '.' . $file->extension, '_blank', "style='text-decoration: underline'");
            if($managePriv or $this->app->user->account == $file->addedBy) echo ' ' . html::a(inlink('deleteFile', "fileID=$file->id&objectID=$objectID&objectType=$type"), 'Ｘ', '', "title='{$this->lang->delete}' class='delete'");
            echo ' ';
        }
    }
}
