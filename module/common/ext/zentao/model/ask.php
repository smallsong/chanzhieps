<?php
public function printAsk($module, $question = '', $method = '')
{
    $method = $method == 'faq' ? 'faq' : 'index';
    $index  = $method == 'faq' ? 'faq' : 'ask';
    echo ' > ' . html::a(helper::createLink('ask', $method), $this->lang->position[$index]);
    if(!$module) return false;
    foreach($module->pathNames as $moduleID => $moduleName) echo ' > ' . html::a(inlink('browse', "moduleID=$moduleID"), $moduleName);
    if($question) echo ' > ' . $question->title;
}
