<?php
/**
 * The control file of file module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file
 * @version     $Id: control.php 1042 2010-08-19 09:02:39Z yuren_@126.com $
 * @link        http://www.xirang.biz
 */
class file extends control
{
    /**
     * Build the upload form.
     * 
     * @param int $fileCount 
     * @param float $percent 
     * @access public
     * @return void
     */
    public function buildForm($fileCount = 2, $percent = 0.9)
    {
        $this->view->fileCount = $fileCount;
        $this->view->percent   = $percent;
        $this->display();
    }

    /**
     * Build the list part of files.
     * 
     * @param array $files
     * @access public
     * @return string
     */
    public function buildList($files)
    {
        $this->view->files = $files;
        $this->display();
    }

    /**
     * AJAX: the api to recive the file posted through ajax.
     * 
     * @access public
     * @return array
     */
    public function ajaxUpload()
    {
        $file = $this->file->getUpload('imgFile');
        $file = $file[0];
        if($file)
        {
            move_uploaded_file($file['tmpname'], $this->file->savePath . $file['pathname']);
            $url =  $this->file->webPath . $file['pathname'];

            $file['addedBy']    = $this->app->user->account;
            $file['addedDate']  = helper::today();
            unset($file['tmpname']);
            $this->dao->insert(TABLE_FILE)->data($file, false)->exec();

            die(json_encode(array('error' => 0, 'url' => $url)));
        }
    }

    /**
     * The list page of an object
     * 
     * @param  string $objectType 
     * @param  int    $objectID 
     * @access public
     * @return void
     */
    public function browse($objectType, $objectID)
    {
        $this->view->objectType = $objectType;
        $this->view->objectID   = $objectID;
        $this->view->files      = $this->file->getByObject($objectType, $objectID);
        $this->display();
    }
  
    /**
     * Edit for the file
     * 
     * @param  string $objectType 
     * @param  int    $objectID 
     * @access public
     * @return void
     */
    public function edit($fileID)
    {
        $file = $this->file->getById($fileID);
        if(!empty($_POST))
        {
            $this->file->edit($fileID);
            if(dao::isError())die(js::error(dao::getError()));
            die(js::locate(inlink('browse',"objectType=$file->objectType&objectID=$file->objectID"),'parent'));
        }
        $this->view->file = $file;
        $this->display();
    }

    /**
     * Upload files for an object.
     * 
     * @param  string $objectType 
     * @param  string $objectID 
     * @access public
     * @return void
     */
    public function upload($objectType, $objectID)
    {
        $files = $this->loadModel('file')->getUpload('files');
        if($files) $this->file->saveUpload($objectType, $objectID);
        die(js::reload('parent'));
    }

    /**
     * Download a file.
     * 
     * @param string $id 
     * @access public
     * @return void
     */
    public function download($id)
    {
        $file = $this->file->getById($id);
        if(file_exists($file->realPath))
        {
            if($file->public)
            {
                $this->dao->update(TABLE_FILE)->set('downloads = downloads + 1')->where('id')->eq($id)->exec(false);
                $this->locate($file->webPath);
            }
            else
            {
                if($this->app->user->account == 'guest') $this->locate($this->createLink('user', 'login'));
                $this->dao->update(TABLE_FILE)->set('downloads = downloads + 1')->where('id')->eq($id)->exec(false);
                $this->locate($file->webPath);
            }
        }
        else
        {
            die('File not found');
        }
    }

    /**
     * Allow a file to public.
     * 
     * @param  int  $fileID 
     * @access public
     * @return void
     */
    public function allow($fileID)
    {
        $this->dao->update(TABLE_FILE)->set('public')->eq(1)->where('id')->eq($fileID)->exec(false);
        die(js::reload('parent'));
    }

    /**
     * Deny a file from public.
     * 
     * @param  int  $fileID 
     * @access public
     * @return void
     */
    public function deny($fileID)
    {
        $this->dao->update(TABLE_FILE)->set('public')->eq(0)->where('id')->eq($fileID)->exec(false);
        die(js::reload('parent'));
    }

    /**
     * Export as csv format.
     * 
     * @access public
     * @return void
     */
    public function export2CSV()
    {
        $this->view->fields = $this->post->fields;
        $this->view->rows   = $this->post->rows;
        $output = $this->parse('file', 'export2csv');

        /* If the language is zh-cn, convert to gbk. */
        $clientLang = $this->app->getClientLang();
        if($clientLang == 'zh-cn')
        {
            if(function_exists('mb_convert_encoding'))
            {
                $output = @mb_convert_encoding($output, 'gbk', 'utf-8');
            }
            elseif(function_exists('iconv'))
            {
                $output = @iconv('utf-8', 'gbk', $output);
            }
        }

        $this->sendDownHeader($this->post->fileName, 'csv', $output);
    }

    /**
     * Send the download header to the client.
     * 
     * @param  string    $fileName 
     * @param  string    $extension 
     * @access public
     * @return void
     */
    public function sendDownHeader($fileName, $fileType, $content)
    {
        /* Set the downloading cookie, thus the export form page can use it to judge whether to close the window or not. */
        setcookie('downloading', 1);

        /* Append the extension name auto. */
        $extension = '.' . $fileType;
        if(strpos($fileName, $extension) === false) $fileName .= $extension;

        /* urlencode the filename for ie. */
        if(strpos($this->server->http_user_agent, 'MSIE') !== false) $fileName = urlencode($fileName);

        /* Judge the content type. */
        $mimes = $this->config->file->mimes;
        $contentType = isset($mimes[$fileType]) ? $mimes[$fileType] : $mimes['default'];

        header("Content-type: $contentType");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        die($content);
    }
}
