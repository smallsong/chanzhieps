<?php
public function printTranslation($zentaoVersion, $language = '')
{
    echo '> ' . html::a(inlink('index', "zentaoVersion=$zentaoVersion"), $this->lang->translation->translate . ' ' . $this->lang->translation->zentaoVersions[$zentaoVersion]);
    if($language) echo '> ' . $this->lang->translation->langs[$language];
}
