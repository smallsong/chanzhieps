<?php
public function deleteReply($replyID)
{
    $author = $this->dao->select('author')->from(TABLE_REPLY)->where('id')->eq($replyID)->fetch('author');
    parent::deleteReply($replyID);
    $this->loadModel('score')->punish($author, 'delReply', $this->config->score->counts->delReply, 'reply', $replyID);
}
