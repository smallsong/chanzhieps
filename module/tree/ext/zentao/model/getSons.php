<?php
    public function getSons($moduleID, $tree = 'article')
    {
        if($tree == 'video')
        {
            return $this->dao->select('*')->from(TABLE_VIDEOMODULE)
                ->orderBy('`order`')
                ->fetchAll();
        }
        return $this->dao->select('*')->from(TABLE_MODULE)
            ->where('parent')->eq((int)$moduleID)
            ->andWhere('tree')->eq($tree)
            ->orderBy('`order`')
            ->fetchAll();
    }
