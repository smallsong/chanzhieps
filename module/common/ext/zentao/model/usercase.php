<?php
public function printUserCase($module, $case = '')
{
    echo ' > ' . html::a(helper::createLink('usercase', 'index'), $this->lang->position['usercase']);
    if(!$module) return false;
    echo ' > ' . html::a(helper::createLink('usercase', 'browse', "type=$module->type&param=$module->param"), $module->name);
    if($case) echo ' > ' . $case->company;
}
