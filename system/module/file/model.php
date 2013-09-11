<?php
/**
 * The model file of file module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php
class fileModel extends model
{
    public $savePath = '';
    public $webPath  = '';
    public $now      = 0;

    /**
     * The construct function, set the save path and web path.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->now = time();
        $this->setSavePath();
        $this->setWebPath();
    }

    /**
     * Get files of an object list.
     * 
     * @param   string  $objectType 
     * @param   mixed   $object 
     * @param   bool    $isImage 
     * @access public
     * @return array
     */
    public function getByObject($objectType, $object, $isImage = false)
    {
        $files = $this->dao->select('*')
            ->from(TABLE_FILE)
            ->where('objectType')->eq($objectType)
            ->andWhere('objectID')->in($object)
            ->beginIf($isImage)->andWhere('extension')->in($this->config->file->imageExtensions)->orderBy('`primary`')->fi() 
            ->fetchGroup('objectID');

        foreach($files as &$fileList) $fileList = $this->batchProcessFile($fileList);

        /* if object is an objectID return without group. */
        if(is_numeric($object)) $files = $files[$object];

        return $files;
    }

    /**
     * processFile just is image and add smallURL and middleURL if necessary.
     *
     * @param  object $file
     * @return object
     */    
    public function processFile($file)
    {
        $file->fullURL   = $this->webPath . $file->pathname;
        $file->middleURL = '';
        $file->smallURL  = '';

        $file->isImage   = false;
        if(in_array(strtolower($file->extension), $this->config->file->imageExtensions) !== false)
        {
            $file->middleURL = $this->webPath . str_replace('f_', 'm_', $file->pathname);
            $file->smallURL  = $this->webPath . str_replace('f_', 's_', $file->pathname);
            $file->isImage   = true;
        }

        return $file;
    }
    
    /**
     * batch run processFile function.
     * 
     * @param array $files
     * @return array
     */
    public function batchProcessFile($files)
    {
        foreach($files as &$file) $file = $this->processFile($file);
        return $files;
    }

    /**
     * Get info of a file.
     * 
     * @param string $fileID 
     * @access public
     * @return void
     */
    public function getByID($fileID)
    {
        $file = $this->dao->findById($fileID)->from(TABLE_FILE)->fetch('', false);
        $file->realPath = $this->app->getDataroot() . "upload/" . $file->pathname;
        $file->webPath  = $this->webPath . $file->pathname;
        return $file;
    }

    /**
     * Save the files uploaded.
     * 
     * @param string $objectType 
     * @param string $objectID 
     * @param string $extra 
     * @access public
     * @return void
     */
    public function saveUpload($objectType = '', $objectID = '', $extra = '')
    {
        $fileTitles = array();
        $now        = helper::now();
        $files      = $this->getUpload();

        foreach($files as $id => $file)
        {
            if(!move_uploaded_file($file['tmpname'], $this->savePath . $file['pathname'])) return false;
            $file['objectType'] = $objectType;
            $file['objectID']   = $objectID;
            $file['addedBy']    = $this->app->user->account;
            $file['addedDate']  = $now;
            $file['extra']      = $extra;
            unset($file['tmpname']);
            $this->dao->insert(TABLE_FILE)->data($file, false)->exec();
            $fileTitles[$this->dao->lastInsertId()] = $file['title'];
        }
        return $fileTitles;
    }

    /**
     * Get the count of uploaded files.
     * 
     * @access public
     * @return void
     */
    public function getCount()
    {
        return count($this->getUpload());
    }

    /**
     * get uploaded files.
     * 
     * @param string $htmlTagName 
     * @access public
     * @return void
     */
    public function getUpload($htmlTagName = 'files')
    {
        $files = array();
        if(!isset($_FILES[$htmlTagName])) return $files;
        /* The tag if an array. */
        if(is_array($_FILES[$htmlTagName]['name']))
        {
            extract($_FILES[$htmlTagName]);
            foreach($name as $id => $filename)
            {
                if(empty($filename)) continue;
                $file['extension'] = $this->getExtension($filename);
                $file['pathname']  = $this->setPathName($id, $file['extension']);
                $file['title']     = !empty($_POST['labels'][$id]) ? htmlspecialchars($_POST['labels'][$id]) : str_replace('.' . $file['extension'], '', $filename);
                $file['size']      = $size[$id];
                $file['tmpname']   = $tmp_name[$id];
                $files[] = $file;
            }
        }
        else
        {
            if(empty($_FILES[$htmlTagName]['name'])) return $files;
            extract($_FILES[$htmlTagName]);
            $file['extension'] = $this->getExtension($name);
            $file['pathname']  = $this->setPathName(0, $file['extension']);
            $file['title']     = !empty($_POST['labels'][0]) ? htmlspecialchars($_POST['labels'][0]) : substr($name, 0, strpos($name, $file['extension']) - 1);
            $file['size']      = $size;
            $file['tmpname']   = $tmp_name;
            return array($file);
        }
        return $files;
    }

    /**
     * Get extension name of a file.
     * 
     * @param string $filename 
     * @access public
     * @return void
     */
    public function getExtension($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if(empty($extension)) return 'txt';
        if(strpos($this->config->file->dangers, $extension) !== false) return 'txt';
        return $extension;
    }

    /**
     * Set the path name.
     * 
     * @param string $fileID 
     * @param string $extension 
     * @access public
     * @return void
     */
    public function setPathName($fileID, $extension)
    {
        $sessionID  = session_id();
        $randString = substr($sessionID, mt_rand(0, strlen($sessionID) - 5), 3);
        $pathName   = date('Ym/dHis', $this->now) . $fileID . mt_rand(0, 10000) . $randString;

        /* rand file name more */
        list($path, $file) = explode('/', $pathName);
        $file = md5(mt_rand(0, 10000) . str_shuffle(md5($file)) . mt_rand(0, 10000));
        return $path . '/' . $file . '.' . $extension;
    }

    /**
     * Set the save path.
     * 
     * @access public
     * @return void
     */
    public function setSavePath()
    {
        $savePath = $this->app->getDataRoot() . "upload/" . date('Ym/', $this->now);
        if(!file_exists($savePath)) @mkdir($savePath, 0777, true);
        $this->savePath = dirname($savePath) . '/';
    }
    
    /**
     * Set the web path.
     * 
     * @access public
     * @return void
     */
    public function setWebPath()
    {
        $this->webPath = $this->app->getWebRoot() . "data/upload/";
    }

    /**
     * Edit rile
     * 
     * @param  int    $fileID 
     * @access public
     * @return void
     */
    public function edit($fileID)
    {
        $this->replaceFile($fileID);
        
        $fileInfo = fixer::input('post')->remove('pathname')->get();
        $this->dao->update(TABLE_FILE)->data($fileInfo, false)->autoCheck()->batchCheck('title', 'notempty')->where('id')->eq($fileID)->exec(false);
    }
    
    /**
     * Replace a file.
     * 
     * @access public
     * @return bool 
     */
    public function replaceFile($fileID, $postName = 'upFile')
    {
        if($files = $this->getUpload($postName))
        {
            $file = $files[0];
            $filePath = $this->dao->select('pathname')->from(TABLE_FILE)->where('id')->eq($fileID)->fetch('', false);
            $pathName = $filePath->pathname;
            $realPathName= $this->savePath . $pathName;
            move_uploaded_file($file['tmpname'], $realPathName);

            $fileInfo->addedBy   = $this->app->user->account;
            $fileInfo->addedDate = helper::now();
            $fileInfo->size      = $file['size'];
            $this->dao->update(TABLE_FILE)->data($fileInfo, false)->where('id')->eq($fileID)->exec(false);
            return true;
        }
        else
        {
            return false;
        }
    }
 
    /**
     * Save file download log.
     *
     * @param int $file
     * @return bool
     */
    public function log($file)
    {
        $log = new stdClass();
        $log->file    = $file;
        $log->account = $this->app->user->account;
        $log->ip      = $this->server->remote_addr;
        $log->referer = $this->server->http_referer;
        $log->time    = helper::now();

        $this->dao->insert(TABLE_DOWN)->data($log)->exec();
        $this->dao->update(TABLE_FILE)->set('downloads = downloads + 1')->where('id')->eq($file)->exec(false);

        return !dao::isError();
    }

    /**
     * Delete the record and the file
     * 
     * @param  int    $fileID 
     * @access public
     * @return void
     */
    public function delete($fileID, $null = null)
    {
        $file = $this->getByID($fileID);
        if(file_exists($file->realPath)) unlink($file->realPath);
        $this->dao->delete()->from(TABLE_FILE)->where('id')->eq($file->id)->exec();
        return !dao::isError();
    }
    
    /**
     * Print files.
     * 
     * @param  object $files 
     * @access public
     * @return void
     */
    public function printFiles($files)
    {
        if(empty($files)) return false;

        foreach($files as $file)
        {
            if(!$file->isImage)
            {
                $file->title = $file->title . ".$file->extension";
                echo html::a(helper::createLink('file', 'download', "fileID=$file->id&mouse=left"), $file->title, '_blank'); 
            }
        }
    }
}
