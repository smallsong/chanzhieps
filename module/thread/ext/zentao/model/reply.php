<?php
public function reply($threadID)
{
    $replyID = parent::reply($threadID);
    if($replyID) $this->loadModel('score')->earn('reply', 'reply', $replyID);

    return $replyID;
}
