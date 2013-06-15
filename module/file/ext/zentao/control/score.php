<?php
/**
 * The score method of file module of XiRangBPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class file extends control
{
    public function score()
    {
        foreach($this->post->scores as $fileID => $score)
        {
            $this->dao->update(TABLE_FILE)->set('score')->eq($score)->where('id')->eq($fileID)->exec(false);
        }
        die(js::reload('parent'));
    }
}
