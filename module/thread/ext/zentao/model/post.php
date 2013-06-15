<?php
public function post($module)
{
    $threadID = parent::post($module);
    if($threadID) $this->loadModel('score')->earn('thread', 'thread', $threadID);
}
