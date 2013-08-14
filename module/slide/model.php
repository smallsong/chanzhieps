<?php
/**
 * The model file of slide module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     slide
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php
class slideModel extends model
{
    /**
     * Get one slide by id.
     *
     * @param int $id
     * @access public
     * @return array
     */
    public function getByID($id)
    {
        $slide = $this->dao->select('*')->from(TABLE_CONFIG)->where('id')->eq($id)->fetch();
        if(!$slide) return false;

        return json_decode($slide->value);
    }

    /**
     * Get slides list sorted by key.
     *
     * @access public
     * @return array
     */
    public function getList()
    {
        $slides = $this->dao->select('*')->from(TABLE_CONFIG)
            ->where('owner')->eq('system')
            ->andWhere('module')->eq('common')
            ->andWhere('section')->eq('slides')
            ->orderBy('`key`')
            ->fetchAll('key');

        foreach($slides as $key => $slide)
        {
            $id = $slide->id;
            $slides[$key] = json_decode($slide->value);
            $slides[$key]->id = $id; 
        }

        return $slides;
    }

    /**
     * Create a slide.
     *
     * @access public
     * @return bool
     */
    public function create()
    {
        if(empty($_FILES)) $this->send(array('result' => 'fail', 'message' => $this->lang->slide->noImageSelected));

        $image = $this->uploadImage();
        if(!$image) $this->send(array('result' => 'fail', 'message' => $this->lang->error->fail));

        $slide = fixer::input('post')->add('image', $image)->get();

        $setting = new stdclass();
        $setting->owner   = 'system';
        $setting->module  = 'common';
        $setting->section = 'slides';
        $setting->value   = helper::jsonEncode($slide);

        $slideKeys    = isset($this->config->slides) ? array_keys((array)$this->config->slides) : array(0);
        $setting->key = max($slideKeys) + 1;

        $this->dao->insert(TABLE_CONFIG)->data($setting)->exec();

        return !dao::isError();
    }

    /**
     * Update a slide.
     *
     * @param int $id
     * @access public
     * @return bool
     */
    public function update($id)
    {
        $image = $this->uploadImage();

        $slide = fixer::input('post')->setIf(!empty($image), 'image', $image)->get();

        $this->dao->update(TABLE_CONFIG)
            ->set('value')->eq(helper::jsonEncode($slide))
            ->where('id')->eq($id)
            ->exec();
        return !dao::isError();
    }

    /**
     * Sort slides
     *
     * @access public
     * @return bool
     */
    public function sort()
    {
        /* Count maxKey to avoid  duplicate entry system-common-slides-key. */
        $maxKey = $this->dao->select('max(`key`) as maxKey')->from(TABLE_CONFIG)
            ->where('owner')->eq('system')
            ->andWhere('module')->eq('common')
            ->andWhere('section')->eq('slides')
            ->fetch('maxKey');

        /* Reset key to zero to make sure key wouldnot overflow. */
        if($maxKey > 1000) $maxKey = 0;

        foreach($_POST['order'] as $id => $order)
        {
            /* Add maxKey to key ensure unique.*/
            $key = $maxKey + $order;
            $this->dao->update(TABLE_CONFIG)
                ->data(array('key' => $key))
                ->where('id')->eq($id)
                ->exec();
        }

        return !dao::isError();
    }

    /**
     * upload image for slide. 
     *
     * @access public
     * @return string webPath
     */
    public function uploadImage()
    {
        $images = $this->loadModel('file')->saveUpload('slide');
        if(!$images) return false; 

        $imageIdList = array_keys($images);
        $image       = $this->file->getById($imageIdList[0]); 

        return $image->webPath;
    }

    /**
     * Delete a slide.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $this->dao->delete()->from(TABLE_CONFIG)
            ->where('id')->eq($id)
            ->exec();
        return !dao::isError();
    }
}
