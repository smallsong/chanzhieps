<?php
/**
 * The control file of comment module of XiRangEPS.
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

            if(!isset($_POST['verifyCode']) && $this->comment->isGarbage($_POST['content'])) $this->send(array('result' => 'success', 'message' => array('notice' => $this->lang->securityCode)) );

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
    public function getLatest($status = '0', $recTotal = 0, $recPerPage = 5, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        $this->view->comments = $this->comment->getList($status, $pager);
        $this->view->pager    = $pager;
        $this->view->status   = $status;
        $this->display();
    }

    /**
     * Delete check garbage comment.
     * 
     * @access public
     * @return void

     */
    public function isGarbage()
    {
        $content = $_POST['content'];
        if($this->comment->isGarbage($content)) die('1');
        die('0');
    }

    /** 
     * @param string $commentID 
     * @param string $type          single|pre
     * @param string $confirm 
     * @access public
     * @return void
     */
    public function delete($commentID, $type, $status = 0, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            $confirm = ($type == 'single') ? $this->lang->comment->confirmDeleteSingle : $this->lang->comment->confirmDeletePre;
            echo js::confirm($confirm, inlink('delete', "commentID=$commentID&type=$type&status=$status&confirm=yes"));
            exit;
        }
        else
        {
            $this->comment->delete($commentID, $type);
            die(js::locate(inlink('getlatest', "status=$status"), 'parent'));
        }
    }

    /**
     * Pass comments.
     * 
     * @param string $commentID 
     * @param string $type 
     * @param string $confirm 
     * @access public
     * @return void
     */
    public function pass($commentID, $type, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            $confirm = ($type == 'single') ? $this->lang->comment->confirmPassSingle : $this->lang->comment->confirmPassPre;
            echo js::confirm($confirm, inlink('pass', "commentID=$commentID&type=$type&confirm=yes"));
            exit;
        }
        else
        {
            $this->comment->pass($commentID, $type);
            die(js::locate(inlink('getlatest'), 'parent'));
        }
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

    public function checkCode()
    {
       echo  $this->comment->setVerify();
            
    }
}
