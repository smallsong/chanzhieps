<?php
public function printExtension($module, $extension = '', $type)
{
    echo ' > ' . html::a(helper::createLink('extension', 'browse'), $this->lang->position['extension']);

    if($type == 'bymodule')
    {
        foreach($module->pathNames as $moduleID => $moduleName) echo ' > ' . html::a(inlink('browse', "type=$type&moduleID=$moduleID"), $moduleName);
    }
    elseif($type)
    {
        echo ' > ' . html::a(helper::createLink('extension', 'browse', "type=$type"), $this->lang->extension->$type);
    }

    if($extension) echo ' > ' . $extension->name;
}
