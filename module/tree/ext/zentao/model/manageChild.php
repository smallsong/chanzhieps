<?php   
public function manageChild($tree, $parentModuleID, $childs)
{
    if($tree == 'video')
    {
        $i = 1;
        foreach($childs as $moduleID => $moduleName)
        {
            if(empty($moduleName)) continue;

            /* The new module. */
            if(is_numeric($moduleID))
            {
                $module->name    = $moduleName;
                $module->order   = $this->post->maxOrder + $i * 10;
                $this->dao->insert(TABLE_VIDEOMODULE)->data($module)->exec();
                $i ++;
            }
            /* The exisiting module. */
            else
            {
                $moduleID = str_replace('id', '', $moduleID);
                $this->dao->update(TABLE_VIDEOMODULE)->set('name')->eq($moduleName)->where('id')->eq($moduleID)->limit(1)->exec();
            }
        }
    }
    else
    {
        $parentModule = $this->getByID($parentModuleID);
        if($parentModule)
        {
            $grade      = $parentModule->grade + 1;
            $parentPath = $parentModule->path;
        }
        else
        {
            $grade      = 1;
            $parentPath = ',';
        }

        $i = 1;
        foreach($childs as $moduleID => $moduleName)
        {
            if(empty($moduleName)) continue;

            /* The new module. */
            if(is_numeric($moduleID))
            {
                $module->id      = $this->dao->select('MAX(id)+1 as id')->from(TABLE_MODULE)->fetch('id', false);
                $module->name    = $moduleName;
                $module->parent  = $parentModuleID;
                $module->grade   = $grade;
                $module->tree    = $tree;
                $module->order   = $this->post->maxOrder + $i * 10;
                $module->path    = $parentPath . "$module->id,";
                $this->dao->insert(TABLE_MODULE)->data($module)->exec();
                 $i ++;
            }
            /* The exisiting module. */
            else
            {
                $moduleID = str_replace('id', '', $moduleID);
                $this->dao->update(TABLE_MODULE)->set('name')->eq($moduleName)->where('id')->eq($moduleID)->exec(false);
            }
        }
    }
}
