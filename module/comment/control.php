<?php
/**
 * The control file of comment module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     comment
 * @version     $Id$
 * @link        http://www.xirang.biz
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
    public function show($objectType, $objectID, $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        $this->view->thisUri = inlink('show',array('objectType' => $objectType, 'objectID'=>$objectID));

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
            $errors = $this->comment->getValidateErrors();
            if(!empty($errors)) $this->send(array('result' => 'fail', 'message' => $errors));

            if(!isset($_POST['captcha']) && $this->comment->isGarbage($_POST['content'])) $this->send(array('result' => 'success', 'message' => array('notice' => $this->lang->captcha)) );

            $commentID = $this->comment->post();
            if(!$commentID) $this->send( array('result' => 'fail', 'message' => dao::getError() ) );
            if(dao::isError()) $this->send( array('result' => 'fail', 'message' => dao::getError() ) );
            $this->comment->setCookie($commentID);
            $this->send( array('result' => 'success', 'message' => $this->lang->comment->thanks) );
        }
    }

    /**
     * Get the latest approvaled comments.
     * 
     * @param string $status 
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function browseAdmin($status = '0', $recTotal = 0, $recPerPage = 5, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        $this->view->comments = $this->comment->getList($status, $pager);
        $this->view->pager    = $pager;
        $this->view->status   = $status;
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
     * @param int    $commentID 
     * @param string $type 
     * @access public
     * @return void
     */
    public function pass($commentID, $type)
    {
        $this->comment->pass($commentID, $type);
        if(!dao::isError()) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Print the latests comments in block.
     * 
     * @param string $count     the total number of comments 
     * @param string $words     the words of every comment to show.
     * @access public
     * @return void
     */
    public function printBlock($count, $words)
    {
        echo "<div id='commentbox'>";
        $comments = $this->comment->getLatest($count);
        foreach($comments as $id => $comment)
        {
            $number = $id + 1;
            $comment->content = nl2br(trim(mb_strimwidth($comment->content, 0, $words, '...')));
            $objectLink = $this->comment->getObjectLink($comment);
            echo "<div class='comment'><strong>#$number $comment->author</strong> at <i>$comment->date</i>: $comment->content";
            echo '<i>(';
            echo html::a($objectLink, $this->lang->comment->viewArticle);
            echo html::a($objectLink . "#$comment->id", $this->lang->comment->viewComment);
            echo ')</i></div>';
        }
        echo '</div>';
    }

    public function ajaxGetComment($objectType, $objectID, $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        $comments    = $this->comment->getByObject($objectType, $objectID, $pager);
        $commentCont = '';
        foreach($comments as $number => $comment)
        {
            $commentCont .= "<div id='$comment->id'  class='comment'>";
            $commentCont .= "<strong>#" . ($number + 1) . $comment->author . "</strong> at $comment->date<br />";
            $commentCont .= nl2br($comment->content);
            $commentCont .= "</div>";
        }
        $commentCont .= "<div id='pager'>" . preg_replace("/<a href='(.*)'.*>(.*)<\/a>/U", "<a href='javascript:ajaxGetComment(\"\$1\")'>\$2</a>", $pager->get('right', 'sort')) . "</div>";
        $commentCont .= "<div class='c-right'></div>";
        
        echo $commentCont;
    }

     /**
     * Check a comemnt is garbage and show captcha if necessary.
     * 
     * @access public
     * @return void
     *
     */    
    public function captcha()
    {
        if($this->comment->isGarbage($this->post->content)) echo $this->comment->captcha();
        die();
    }
}
