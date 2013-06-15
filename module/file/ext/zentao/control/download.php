<?php
/**
 * The down method of file module of XiRangBPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class file extends control
{
    /**
     * Download a file.
     * 
     * @param string $id 
     * @access public
     * @return void
     */
    public function download($id, $confirm = '', $extra = '')
    {
        if($confirm == 'no') die(js::close());
        $file = $this->file->getById($id);
        if(!file_exists($file->realPath)) die('file not found');
        if($file->public)
        {
            $this->dao->update(TABLE_FILE)->set('downloads = downloads + 1')->where('id')->eq($id)->exec(false);
            $extension = $this->dao->select('id, account')->from(TABLE_EXTENSION)->where('code')->eq($file->title)->fetchPairs('id', '', false);
            foreach($extension as $key => $value)
            {
                $this->loadModel('score')->award($value, 'downextension', '10', 'extension', $key, "EXTENSION:$key");
            }
            if($file->objectType != 'extRelease') die($this->locate($file->webPath));
        }
        else
        {
            $account = $this->app->user->account;
            if($account == 'guest') die(js::locate($this->createLink('user', 'login'), 'parent'));

            /* Check for update extension.*/
            if($file->objectType == 'extRelease')
            {
                $extension     = $this->dao->select('extension')->from(TABLE_EXTRELEASE)->where('id')->eq($file->objectID)->fetch('extension', false);
                $releaseFiles  = $this->dao->select('t1.id')->from(TABLE_FILE)->alias('t1')
                                 ->leftJoin(TABLE_EXTRELEASE)->alias('t2')->on('t1.objectID = t2.id')
                                 ->where('t1.objectType')->eq('extRelease')
                                 ->andWhere('t2.extension')->eq($extension)
                                 ->fetchAll('id', false);
                $hasFileDowned = $this->dao->select('id')->from(TABLE_SCORE)->where('account')->eq($this->app->user->account)->andWhere('objectType')->eq('file')->andWhere('objectID')->in(array_keys($releaseFiles))->fetch('', false);
                if($hasFileDowned) $file->score = $file->score / 2;
            }

            if(!$this->loadModel('score')->hasFileDowned($account, $id) and $account != $file->addedBy)
            {
                if(!empty($file->score) and ($file->addedBy != $this->app->user->account) and $confirm == '')
                {
                    die(js::confirm(sprintf($this->lang->file->confirm, $file->score), inlink('download', "id=$id&confirm=yes&extra=$extra"), inlink('download', "id=$id&confirm=no")));
                }

                if(!$this->score->cost('download', $file->score, 'file', $id))
                {
                    $this->view->score = $file->score;
                    die($this->display());
                }
                if($file->objectType == 'extRelease') $this->score->award($file->addedBy, 'earnExtension', $file->score, 'extension', $id);
            }
            $this->dao->update(TABLE_FILE)->set('downloads = downloads + 1')->where('id')->eq($id)->exec(false);
        }

        if($file->objectType == 'extRelease')
        {
            $extRelease = $this->dao->select('*')->from(TABLE_EXTRELEASE)->where('id')->eq($file->objectID)->fetch('', false);
            if(!empty($extra))
            {
                $order = $this->dao->select('*')->from(TABLE_EXTORDER)->where('id')->eq($extra)->fetch('', false);
                $file->realPath = $order->downLink;
            }
            $this->dao->update(TABLE_EXTENSION)->set('downloads = downloads + 1')->where('id')->eq($extRelease->extension)->exec(false);
        }

        $fileName = $file->title . '.' . $file->extension;
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) $fileName = urlencode($fileName);
        header('Content-Description: File Transfer');
        header('Content-type: application/octet-stream');
        header("Content-Disposition: attachment; filename=$fileName");
        header('Content-Length: ' . filesize($file->realPath));
        readfile($file->realPath);
        die();
    }
}
