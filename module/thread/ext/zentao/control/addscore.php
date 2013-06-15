<?php
class thread extends control
{
    public function addScore($account, $objectType, $objectID, $score)
    {
        if(!$this->app->user->isAdmin) die();
        $max   = max(array_keys($this->lang->thread->scores));
        $score = (int)$score;
        if($score > $max) $score = $max;

        $account = helper::safe64Decode($account);
        if($objectType == 'thread') $this->loadModel('score')->award($account, 'valueThread', $score, $objectType, $objectID);
        if($objectType == 'reply')  $this->loadModel('score')->award($account, 'valueReply',  $score, $objectType, $objectID);
        die(js::reload('parent'));
    }
}
