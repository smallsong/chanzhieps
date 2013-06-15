<?php
class tree extends control
{
    public function deleteVideo($moduleID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            echo js::confirm($this->lang->tree->confirmDelete, $this->createLink('tree', 'deleteVideo', "moduleID=$moduleID&confirm=yes"));
            exit;
        }
        else
        {
            $this->tree->deleteVideo($moduleID);
            die(js::reload('parent'));
        }
    }
}
