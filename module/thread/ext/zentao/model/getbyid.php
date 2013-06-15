<?php
public function getByID($threadID, $pager = null)
{
    $thread = parent::getByID($threadID, $pager);
    if($thread)
    {
        $thread->scores = $this->loadModel('score')->getByObject('thread', $threadID, 'valuethread');
        foreach($thread->scores as $score) $thread->scoreSum += $score->count;
        if($thread->replies)
        {
            $replyScores = $this->loadModel('score')->getByObject('reply', array_keys($thread->replies), 'valuereply');
            foreach($replyScores as $score)
            {
                $thread->replies[$score->objectID]->scoreSum += $score->count;
            }
        }
    }
    return $thread;
}
