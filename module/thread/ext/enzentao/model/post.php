<?php
public function post($module)
{
    $thread = fixer::input('post')
        ->specialChars('title')
        ->add('author', $this->app->user->account)
        ->add('addedDate', helper::now())
        ->add('lastRepliedDate', helper::now())
        ->add('module', $module)
        ->stripTags('content', $this->config->thread->editor->allowableTags)
        ->remove('files,labels')
        ->get();

    if(trim(strip_tags($thread->content) == '')) $thread->content = '';
    $this->dao->insert(TABLE_THREAD)->data($thread)->autoCheck()->batchCheck('title, content', 'notempty')->exec();

    $threadID = $this->dao->lastInsertID();
    /* Upload file.*/
    $this->uploadFile('thread', $threadID);
    $thread->threadID = $threadID;
    $thread->replyID  = 0;
    $this->loadModel('forum')->updateBoardStats($module, 'thread', $thread);
    return $threadID;
}

private function uploadFile($objectType, $objectID)
{
    $files = $this->loadModel('file')->getUpload('files');
    if($files) $this->file->saveUpload($objectType, $objectID);
}
