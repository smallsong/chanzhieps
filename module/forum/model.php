<?php
/**
 * The model file of forum category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     forum
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class forumModel extends model
{
    /**
     * Get boards.
     * 
     * @access public
     * @return array
     */
    public function getBoards()
    {
        $boards    = array();
        $rawBoards = $this->dao->select('*')->from(TABLE_CATEGORY)->where('type')->eq('forum')->orderBy('grade, `order`')->fetchGroup('parent');
        if(!isset($rawBoards[0])) return $boards;

        foreach($rawBoards[0] as $parentBoard)
        {
            if(isset($rawBoards[$parentBoard->id]))
            {
                $parentBoard->childs = $rawBoards[$parentBoard->id];
                foreach($parentBoard->childs as $childBoard) $childBoard->lastPostReplies = $this->dao->select('COUNT(id) as id')->from(TABLE_REPLY)->where('thread')->eq($childBoard->lastPostID)->fetch('id');
                $boards[] = $parentBoard;
            }
        }
        return $boards;
    }

    /**
     * Update status of boards.
     * 
     * @param string $boardID 
     * @param string $mode 
     * @param string $post 
     * @access public
     * @return void
     */
    public function updateBoardStats($boardID, $mode = 'thread', $post)
    {
        if($mode == 'thread')
        {
            $this->dao->update(TABLE_CATEGORY)
                ->set('threads = threads + 1')
                ->set('posts = posts + 1')
                ->set('lastPostedBy')->eq($post->author)
                ->set('lastPostedDate')->eq($post->addedDate)
                ->set('lastPostID')->eq($post->threadID)
                ->set('lastReplyID')->eq(0)
                ->where('id')->eq($boardID)
                ->exec();
        }
        elseif($mode == 'reply')
        {
            $this->dao->update(TABLE_CATEGORY)
                ->set('posts = posts + 1')
                ->set('lastPostedBy')->eq($post->author)
                ->set('lastPostedDate')->eq($post->addedDate)
                ->set('lastPostID')->eq($post->threadID)
                ->set('lastReplyID')->eq($post->replyID)
                ->where('id')->eq($boardID)
                ->exec();
        }
    }

    /**
     * Judge a board is new or not.
     * 
     * @param string $board 
     * @access public
     * @return void
     */
    public function isNew($board)
    {
         return (time() - strtotime($board->lastPostedDate)) < 24 * 60 * 60 * $this->config->forum->newDays;
    }

    /**
     * Judge a user can post thread to a board or not.
     * 
     * @param  object    $board 
     * @access public
     * @return void
     */
    public function canPost($board)
    {
        /* If the board is an open one, return true. */
        if($board->readonly == false) return true;

        /* Then check the user is admin or not. */
        if($this->app->user->admin == 'super') return true; 

        /* Then check the user is a moderator or not. */
        $user = ",{$this->app->user->account},";
        $moderators = ',' . str_replace(' ', '', $board->moderators) . ',';
        if(strpos($moderators, $user) !== false) return true;

        return false;
    }
}
