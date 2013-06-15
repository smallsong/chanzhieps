<?php
public function getTreeMenu($tree = 'article', $startModuleID = 0, $userFunc)
{
    $treeMenu = array();
    if($tree == 'video')
    {
        $treeMenu[0] = "";
        $videoModules = $this->dao->select('*')->from(TABLE_VIDEOMODULE)->orderBy('`order`')->fetchAll('', false);
        if($userFunc[1] == 'createManageLink')
        {
            foreach($videoModules as $videoModule)
            {
                $linkHtml = $videoModule->name; 
                $linkHtml .= ' ' . html::a(helper::createLink('tree', 'deleteVideo', "moduleID=$videoModule->id"), $this->lang->delete, 'hiddenwin');
                $linkHtml .= ' ' . html::input("orders[$videoModule->id]", $videoModule->order, 'style="width:30px;text-align:center"');
                $treeMenu[0] .= "<li>" . $linkHtml . "</li>";
            }
        }
        else
        {
            foreach($videoModules as $videoModule)
            {
                $linkHtml = html::a(helper::createLink('video', 'browseAdmin', "moduleID=$videoModule->id"), $videoModule->name, 'mainwin');
                $treeMenu[0] .= "<li>" . $linkHtml . "</li>";
            }
       
        }
    }
    else
    {
        $stmt = $this->dbh->query(parent::buildMenuQuery($tree, $startModuleID));
        while($module = $stmt->fetch())
        {
            $linkHtml = call_user_func($userFunc, $module);
            if(isset($treeMenu[$module->id]) and !empty($treeMenu[$module->id]))
            {
                if(!isset($treeMenu[$module->parent])) $treeMenu[$module->parent] = '';
                $treeMenu[$module->parent] .= "<li>$linkHtml";  
                $treeMenu[$module->parent] .= "<ul>".$treeMenu[$module->id]."</ul>\n";
            }
            else
            {
                if(isset($treeMenu[$module->parent]) and !empty($treeMenu[$module->parent]))
                {
                    $treeMenu[$module->parent] .= "<li>$linkHtml\n";  
                }
                else
                {
                    $treeMenu[$module->parent] = "<li>$linkHtml\n";  
                }    
            }
            $treeMenu[$module->parent] .= "</li>\n"; 
        }
    }
    $lastMenu = "<ul class='tree'>" . @array_pop($treeMenu) . "</ul>\n";
    return $lastMenu; 
}
