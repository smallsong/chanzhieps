<?php
public function deleteThread($threadID)
{
    $thread = $this->getByID($threadID);
    parent::deleteThread($threadID);
    $this->loadModel('score')->punish($thread->author, 'delThread', $this->config->score->counts->delThread, 'thread', $threadID);
}
