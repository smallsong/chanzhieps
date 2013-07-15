<?php
/**
 * The model file of comment module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     comment
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class commentModel extends model
{
    /**
     * Get comments of one object.
     * 
     * @param string $objectType    the object type
     * @param string $objectID      the object id
     * @access public
     * @return array
     */
    public function getByObject($objectType, $objectID, $pager = null)
    {
        $userComments = $this->cookie->cmts;
        $comments = $this->dao->select('*')->from(TABLE_COMMENT)
            ->where('objectType')->eq($objectType)
            ->andWhere('objectID')->eq($objectID)
            ->andWhere("(INSTR('$userComments', CONCAT('_',id,'_')) != 0 or status != '0' or author = '{$this->app->user->account}')")
            ->orderBy('id_desc')
            ->page($pager, false)
            ->fetchAll('id', false);
        if(!$comments) return array();
        return array_values($comments);
    }

    /**
     * Get comment list.
     * 
     * @param string $status    the comment status
     * @param string $pager 
     * @access public
     * @return void
     */
    public function getList($status, $pager = null)
    {
        $comments = $this->dao->select('*')->from(TABLE_COMMENT)
            ->where('status')->eq($status)
            ->orderBy('id_desc')
            ->page($pager, false)
            ->fetchAll('id', false);
        $articles = array();
        foreach($comments as $comment) $articles[] = $comment->objectID;
        $articleTitles = $this->dao->select('id, title')->from(TABLE_ARTICLE)->where('id')->in($articles)->fetchPairs('', '', false);
        foreach($comments as $comment)
        {
            $comment->objectTitle = isset($articleTitles[$comment->objectID]) ? $articleTitles[$comment->objectID] : '';
        }
        return $comments;
    }

    /**
     * Get latest comments, the status if ok.
     * 
     * @param int $count 
     * @access public
     * @return void
     */
    public function getLatest($count = 10)
    {
        $commentIdList = $this->dao->select('comment as id')->from(TABLE_COMMENTSITE)->where('status')->eq(1)->orderBy('id_desc')->limit($count)->fetchPairs();
        $comments = $this->dao->select('t1.*,t2.title')->from(TABLE_COMMENT)->alias('t1')
            ->leftJoin(TABLE_ARTICLE)->alias('t2')->on('t1.objectID=t2.id')
            ->where('t1.id')->in($commentIdList)
            ->orderBy('id desc')
            ->fetchAll('', false);
        return $comments;
    }

    /**
     * Post a comment.
     * 
     * @access public
     * @return void
     */
    public function post()
    {
        $comment = fixer::input('post')
            ->specialChars('content')
            ->add('date', helper::now())
            ->add('ip', $this->server->REMOTE_ADDR)
            ->remove('verifyCode')
            ->get();
        $this->dao->insert(TABLE_COMMENT)
            ->data($comment, false)
            ->autoCheck()
            ->checkIF($comment->email, 'email', 'email')
            ->batchCheck('author, content', 'notempty')
            ->exec();
        $commentID = $this->dao->lastInsertId();
        return $commentID;
    }

    /**
     * Delete a comment.
     * 
     * @param string $commentID 
     * @param string $type 
     * @access public
     * @return void
     */
    public function delete($commentID, $type)
    {
        $comment = $this->dao->select('status')->from(TABLE_COMMENT)->where('id')->eq($commentID)->fetch('', false);
        if($comment->status == 0)
        {
            $this->dao->delete()
                ->from(TABLE_COMMENT)
                ->where('status')->eq(0)
                ->beginIF($type == 'single')->andWhere('id')->eq($commentID)->fi()
                ->beginIF($type == 'pre')->andWhere('id')->ge($commentID)->fi()
                ->exec(false);
        }
        else
        {
            $this->dao->delete()->from(TABLE_COMMENT)->where('id')->eq($commentID)->exec(false);
        }
    }

    /**
     * Pass comments.
     * 
     * @param string $commentID 
     * @param string $type          single|pr
     * @access public
     * @return void
     */
    public function pass($commentID, $type)
    {
        $this->dao->update(TABLE_COMMENT)
            ->set('status')->eq(1)
            ->where('status')->eq(0)
            ->beginIF($type == 'single')->andWhere('id')->eq($commentID)->fi()
            ->beginIF($type == 'pre')->andWhere('id')->ge($commentID)->fi()
            ->exec(false);
    }

    /**
     * Set the comemnt id the user posted to the cookie. Thus before approvaled, the user can view these comments.
     * 
     * @param string $commentID
     * @access public
     * @return void
     */
    public function setCookie($commentID)
    {
        $commentID = '_' . $commentID . '_';
        $comments = $this->cookie->cmts;
        if(!$comments)
        {
            $comments = $commentID;
        }
        else
        {
            if(strpos($comments, $commentID) === false)
            {
                $comments .= $commentID;
            }
        }
        setcookie('cmts', $comments);
    }

    /**
     * Get the link of the object of one comment.
     * 
     * @param string $comment 
     * @access public
     * @return sting
     */
    public function getObjectLink($comment)
    {
        if($comment->objectType == 'doc')
        {
            $link = helper::createLink('help', 'read', "articleID=$comment->objectID");
        }
        else
        {
            $link = helper::createLink('article', 'view', "articleID=$comment->objectID");
        }

        return $link;
    }
    
    /**
     * Is garbage comment.
     * 
     * @param  string $content 
     * @access public
     * @return bool
     */
    public function isGarbage($content = '')
    {
        $isGarbage = false;
        if(strpos($content, 'http://') !== false) return true;
        $lineCount = preg_match_all('/(?<=href=)([^\>]*)(?=\>)/ ',$content, $out);
        if($lineCount > 1) $isGarbage = true;
        if($lineCount > 5) die();
        if(preg_match('/\[url=.*\].*\[\/url\]/U', $content))die();
        if($isGarbage and (!isset($_POST['yzm']) or $_SESSION['yzm'] != $_POST['yzm'])) return true; 
        return false;
    }

    /**
     * Set verify code.
     * 
     * @access public
     * @return void
     */
    public function setVerify()
    {
        $numbers   = $this->lang->securityCode->numbers;
        $actions   = $this->lang->securityCode->actions;
        $action    = mt_rand(0, 2);
        $actionKey = array_keys($actions);
        $randMax   = 10;
        $before    = mt_rand(0, $randMax);
        $after     = mt_rand(0, $randMax);
        $action    = $actionKey[$action];
        $yzStr     = $before . $action . $after;
        eval("\$result = $yzStr;");
        $this->session->set('verifyCode', $result);
        echo '<td>' . $this->lang->comment->securityCode . '</td>';
        echo '<td> <span class="label label-important" style="line-height:20px;">' . $numbers[$before] . " $actions[$action] " . $numbers[$after] . "</span>&nbsp;&nbsp;" . $this->lang->securityCode->equal . "&nbsp;&nbsp;";
        echo '<input type="text" name="verifyCode" id="verifyCode" class="w-20px" />' . $this->lang->securityCode->notice . '</td>';
    }

    public function getValidateErrors()
    {
       $errors = array();
       if($this->post->author  == false) $errors['author'] = sprintf($this->lang->error->notempty, $this->lang->comment->author);
       if($this->post->content == false) $errors['content'] = sprintf($this->lang->error->notempty, $this->lang->comment->content);
       if($this->post->email   != '' && !validater::checkEmail($this->post->email)) $errors['email'] = sprintf($this->lang->error->email, $this->lang->comment->email);

       if($this->post->verifyCode !== false && $this->post->verifyCode != $this->session->verifyCode) $errors['verifyCode'] = $this->lang->error->securityCode;

       return $errors;

    }
}
