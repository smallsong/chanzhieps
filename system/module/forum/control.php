<?php
/**
 * The control file of forum category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     forum
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class forum extends control
{
    /**
     * The index page of forum.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->view->title     = $this->lang->forumHome;
        $this->view->boards    = $this->forum->getBoards();
        //$this->view->layouts = $this->loadModel('block')->getLayouts('forum.index');

        $this->display();
    }

    /**
     * The board page.
     * 
     * @param int    $boardID       the board id
     * @param string $orderBy       the order by field
     * @param int    $recTotal      the record total
     * @param int    $recPerPage    the record per page
     * @param int    $pageID        the current page id
     * @access public
     * @return void
     */
    public function board($boardID = 0, $orderBy = 'repliedDate_desc', $recTotal = 0, $recPerPage = 10, $pageID = 1)
    {
        $board = $this->loadModel('tree')->getById($boardID);
        if(!$board) die(js::locate('back'));

        /* Get stick threads. */
        $sticks = $this->loadModel('thread')->getSticks($boardID);

        /* Get common threads. */
        $this->app->loadClass('pager', $static = true);
        $pager   = new pager($recTotal, $recPerPage, $pageID);
        $threads = $this->thread->getList($boardID, $orderBy, $pager);

        $this->view->title     = $board->name;
        $this->view->keyword   = $board->keyword . '' . $this->config->site->keywords;
        $this->view->desc      = strip_tags($board->desc);
        $this->view->board     = $board;
        $this->view->sticks    = $sticks;
        $this->view->threads   = $threads;
        $this->view->pager     = $pager;
        //$this->view->layouts = $this->loadModel('block')->getLayouts('forum.board');

        $this->display();
    }

    /**
     * The admin page of board.
     * 
     * @param int       $boardID 
     * @param string    $orderBy 
     * @param int       $recTotal 
     * @param int       $recPerPage 
     * @param int       $pageID 
     * @access public
     * @return void
     */
    public function admin($boardID = 0, $orderBy = 'repliedDate_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager   = new pager($recTotal, $recPerPage, $pageID);

        $boards  = $this->loadModel('tree')->getFamily($boardID, 'forum');
        $threads = $boards ? $this->loadModel('thread')->getList($boards, $orderBy, $pager) : array();

        $this->view->title   = $this->view->board ? $this->view->board->name : $this->lang->forum->admin;
        $this->view->board   = $this->loadModel('tree')->getById($boardID);
        $this->view->threads = $threads;
        $this->view->pager   = $pager;

        $this->display();
    }

    /**
     * Update stats of boards and threads.
     * 
     * @access public
     * @return void
     */
    public function updateStats()
    {
        $threads = $this->dao->select('id, id')->from(TABLE_THREAD)->fetchPairs('id', 'id', false);
        foreach($threads as $threadID)
        {
            $lastReply = $this->dao->select('*')->from(TABLE_REPLY)->where('thread')->eq($threadID)->orderBy('id desc')->limit(1)->fetch('', false);
            if($lastReply)
            {
                $replies = $this->dao->select('count(*) as count')->from(TABLE_REPLY)->where('thread')->eq($threadID)->fetch('count', false);
                $data->replies     = $replies;
                $data->repliedBy   = $lastReply->author;
                $data->repliedDate = $lastReply->addedDate;
                $data->replyID     = $lastReply->id;
                $this->dao->update(TABLE_THREAD)->data($data, false)->where('id')->eq($threadID)->exec(false);
            }
        }
        unset($data);

        $boards = $this->dao->select('id, name')->from(TABLE_CATEGORY)->where('type')->eq('forum')->andWhere('grade')->eq(2)->fetchPairs('id', 'name', false);
        foreach($boards as $boardID => $boardName)
        {
            $newestPost = $this->dao->select('t1.id as threadID, t1.author, t1.addedDate, t2.id as replyID')
                ->from(TABLE_THREAD)->alias('t1')
                ->leftJoin(TABLE_REPLY)->alias('t2')->on('t1.id = t2.thread')
                ->where('t1.category')->eq($boardID)
                ->orderBy('t1.id desc, t2.id desc')
                ->limit(1)
                ->fetch();

            $newestReply = $this->dao->select('t2.thread as threadID, t2.author, t2.addedDate, t2.id as replyID')
                ->from(TABLE_THREAD)->alias('t1')
                ->leftJoin(TABLE_REPLY)->alias('t2')->on('t1.id = t2.thread')
                ->where('t1.category')->eq($boardID)
                ->orderBy('t2.id desc')
                ->limit(1)
                ->fetch();

            $threadsAndReplies = $this->dao->select('COUNT(id) as threads, SUM(replies) as replies')
                ->from(TABLE_THREAD)
                ->where('category')->eq($boardID)
                ->fetch();

            $this->dao->update(TABLE_CATEGORY)
                ->set('threads')->eq($threadsAndReplies->threads)
                ->set('posts')->eq($threadsAndReplies->threads + $threadsAndReplies->replies)
                ->where('id')->eq($boardID)
                ->exec(false);

            if($newestPost)
            {
                $lastThread = ($newestPost->addedDate > $newestReply->addedDate) ? $newestPost : $newestReply;
                $data->postedBy   = $lastThread->author;
                $data->postedDate = $lastThread->addedDate;
                $data->postID     = $lastThread->threadID;
                $data->replyID    = $lastThread->replyID;
                $this->dao->update(TABLE_CATEGORY)->data($data, false)->where('id')->eq($boardID)->exec(false);
            }
        }
        echo 'success';
    }
}
