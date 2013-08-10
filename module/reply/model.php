<?php
/**
 * The model file of reply module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     reply
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class replyModel extends model
{
    /**
     * Get replies of a thread.
     * 
     * @param  int    $thread 
     * @param  object $pager 
     * @access public
     * @return array
     */
    public function getByThread($thread, $pager = null)
    {
        $replies = $this->dao->select('*')->from(TABLE_REPLY)
            ->where('thread')->eq($thread)
            ->orderBy('id')
            ->page($pager)
            ->fetchAll('id');

        if(!$replies) return array();

        /* Get files for these replies. */
        $files = $this->loadModel('file')->getByObject('reply', array_keys($replies));
        foreach($files as $file) $replies[$file->objectID]->files[$file->id] = $file;

        return $replies;
    }

    /**
     * Get replies of a user.
     * 
     * @param string $account       the account
     * @param string $pager         the pager object
     * @access public
     * @return array
     */
    public function getByUser($account, $pager)
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
            ->stripTags('content', $this->config->thread->editor->allowTags)
            ->remove('captcha, recTotal, recPerPage, pageID, files, labels')
            ->get();

        $this->dao->insert(TABLE_REPLY)->data($reply)->autoCheck()->check('content', 'notempty')->exec();

        if(!dao::isError())
        {
            $replyID = $this->dao->lastInsertID();                     // Get reply id.
            $this->saveCookie($replyID);                               // Save reply id to cookie.
            $this->loadModel('file')->saveUpload('reply', $replyID);   // Save file.

            /* Update the thread info. */
            $thread = $this->dao->findById($threadID)->from(TABLE_THREAD)->fields('replies, board')->fetch();
            $thread->replies += 1;
            $thread->repliedDate = helper::now();
            $thread->repliedBy   = $this->app->user->account;
            $thread->replyID     = $replyID;
            $this->dao->update(TABLE_THREAD)->data($thread)->where('id')->eq($threadID)->exec();

            /* Update board stats. */
            $reply->threadID = $threadID;
            $reply->replyID  = $replyID;
            $this->loadModel('forum')->updateBoardStats($thread->board, 'reply', $reply);
        }
        return;
    }

    /**
     * Update reply.
     * 
     * @param string $replyId 
     * @access public
     * @return void
     */
    public function update($replyId)
    {
        $reply = fixer::input('post')
            ->add('editor', $this->session->user->account)
            ->add('editedDate', helper::now())
            ->stripTags('content', $this->config->thread->editor->allowTags)
            ->remove('yzm,files,labels')
            ->get();
        $this->dao->update(TABLE_REPLY)->data($reply)->autoCheck()->check('content', 'notempty')->where('id')->eq($replyId)->exec();
        /* Upload file.*/
        $this->uploadFile('reply', $replyId);
        return;
    }

    /**
     * Hide a reply. 
     * 
     * @param  string $replyID 
     * @access public
     * @return void
     */
    public function hide($replyID)
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
    public function delete($replyID)
    {
        $this->dao->delete()->from(TABLE_REPLY)->where('id')->eq($replyID)->exec(false);
        return !dao::isError();
    }

    /**
     * Print files of for a reply.
     * 
     * @param  object $thread 
     * @param  bool   $canManage 
     * @access public
     * @return void
     */
    public function printFiles($reply, $canManage)
    {
        if(empty($reply->files)) return false;

        echo '<br /><br />' . $this->lang->reply->file . ":";
        foreach($reply->files as $file)
        {
            $file->title .= ".$file->extension";
            echo html::a(helper::createLink('file', 'download', "fileID=$file->id", $file->title)); 
            if($canManage) echo ' ' . html::a(inlink('deleteFile', "fileID=$file->id&replyID=$reply->id"), 'Ｘ', '', "class='deleter'");
            echo ' ';
        }
    }

    /**
     * Save the reply id to cookie.
     * 
     * @param  int     $replyID 
     * @access public
     * @return void
     */
    public function saveCookie($reply)
    {
        $reply = "$reply,";
        $cookie = $this->cookie->r != false ? $this->cookie->r : ',';
        if(strpos($cookie, $reply) === false) $cookie .= $reply;
        setcookie('r', $cookie , time() + 60 * 60 * 24 * 30);
    }
}
