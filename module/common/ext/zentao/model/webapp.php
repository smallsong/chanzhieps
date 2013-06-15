<?php
public function printWebapp($module, $webapp = '', $type)
{
    echo ' > ' . html::a(helper::createLink('webapp', 'browse'), $this->lang->position['webapp']);

    if($type == 'bymodule')
    {
        foreach($module->pathNames as $moduleID => $moduleName) echo ' > ' . html::a(inlink('browse', "type=$type&moduleID=$moduleID"), $moduleName);
    }
    elseif($type)
    {
        echo ' > ' . html::a(helper::createLink('webapp', 'browse', "type=$type"), $this->lang->webapp->$type);
    }

    if($webapp) echo ' > ' . $webapp->name;
}
