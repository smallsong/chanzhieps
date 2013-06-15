<?php
public function updateVideoOrder($orders)
{
    foreach($orders as $moduleID => $order)
    {
        $this->dao->update(TABLE_VIDEOMODULE)->set('`order`')->eq($order)->where('id')->eq((int)$moduleID)->limit(1)->exec();
    }
}
