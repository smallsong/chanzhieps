<?php
public function deleteVideo($moduleID)
{
    $this->dao->delete()->from(TABLE_VIDEOMODULE)->where('id')->eq($moduleID)->exec();                                 // Delete my self.
}
