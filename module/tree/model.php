<?php
/**
 * The model file of tree module of XiRangBPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php
class treeModel extends model
{
    /**
     * Get module info by id.
     * 
     * @param string $moduleID 
     * @access public
     * @return void
     */
    public function getByID($moduleID)
    {
        $module = $this->dao->findById((int)$moduleID)->from(TABLE_MODULE)->fetch();
        if(!$module) return $module;
        $pathNames   = $this->dao->select('id, name')->from(TABLE_MODULE)->where('id')->in($module->path)->orderBy('grade')->fetchPairs();
        $module->pathNames = $pathNames;
        return $module;
    }

    /**
     * Build the sql to execute.
     * 
     * @param string $tree              the tree type, for example, article|forum
     * @param int    $startModuleID     the start module id
     * @param int    $siteID            the site id
     * @access public
     * @return string
     */
    public function buildMenuQuery($tree, $startModuleID, $siteID = 0)
    {
        /* Get the start module path according the $startModuleID. */
        $startModulePath = '';
        if($startModuleID > 0)
        {
            $startModule = $this->getById($startModuleID);
            if($startModule) $startModulePath = $startModule->path . '%';
        }

        return $this->dao->select('*')->from(TABLE_MODULE)
            ->where('tree')->eq($tree)
            ->beginIF($startModulePath)->andWhere('path')->like($startModulePath)->fi()
            ->beginIF($siteID)->andWhere('site')->eq($siteID)->fi()
            ->orderBy('grade desc, `order`')
            ->get($siteID ? false : true);
    }

    /**
     * Create a tree menu in <select> tag.
     * 
     * @param string $tree 
     * @param int    $startModuleID 
     * @param int    $siteID
     * @access public
     * @return string
     */
    public function getOptionMenu($tree = 'article', $startModuleID = 0, $siteID = 0)
    {
        /* First, get all modules. */
        $treeMenu = array();
        $stmt     = $this->dbh->query($this->buildMenuQuery($tree, $startModuleID, $siteID));
        $modules  = array();
        while($module = $stmt->fetch()) $modules[$module->id] = $module;

        /* Cycle them, build the select control.  */
        foreach($modules as $module)
        {
            $parentModules = explode(',', $module->path);
            $moduleName = '/';
            foreach($parentModules as $parentModuleID)
            {
                if(empty($parentModuleID)) continue;
                $moduleName .= $modules[$parentModuleID]->name . '/';
            }
            $moduleName = rtrim($moduleName, '/');
            $moduleName .= "|$module->id\n";

            if(isset($treeMenu[$module->id]) and !empty($treeMenu[$module->id]))
            {
                if(isset($treeMenu[$module->parent]))
                {
                    $treeMenu[$module->parent] .= $moduleName;
                }
                else
                {
                    $treeMenu[$module->parent] = $moduleName;;
                }
                $treeMenu[$module->parent] .= $treeMenu[$module->id];
            }
            else
            {
                if(isset($treeMenu[$module->parent]) and !empty($treeMenu[$module->parent]))
                {
                    $treeMenu[$module->parent] .= $moduleName;
                }
                else
                {
                    $treeMenu[$module->parent] = $moduleName;
                }    
            }
        }

        $topMenu = @array_pop($treeMenu);
        $topMenu = explode("\n", trim($topMenu));
        $lastMenu[] = '/';
        foreach($topMenu as $menu)
        {
            if(!strpos($menu, '|')) continue;
            $menu     = explode('|', $menu);
            $label    = array_shift($menu);
            $moduleID = array_pop($menu);
            if(!empty($menu) and $this->cookie->lang == 'en') $lable = '/' . $menu;
           
            $lastMenu[$moduleID] = $label;
        }
        return $lastMenu;
    }

    /**
     * Get the id => name pairs of some modules.
     * 
     * @param string $modules   the module lists
     * @param string $tree      the tree
     * @access public
     * @return array
     */
    public function getPairs($modules = '', $tree = '')
    {
        return $this->dao->select('id, name')->from(TABLE_MODULE)
            ->beginIF($modules)->where('id')->in($modules)->fi()
            ->beginIF($tree)->where('tree')->eq($tree)->fi()
            ->fetchPairs();
    }

    /**
     * Get the tree menu in <ul><ol> type.
     * 
     * @param string    $tree           the tree type
     * @param int       $startModuleID  the start module
     * @param string    $userFunc       which function to be called to create the link
     * @access public
     * @return string   the html code of the tree menu.
     */
    public function getTreeMenu($tree = 'article', $startModuleID = 0, $userFunc, $siteID = 0)
    {
        $treeMenu = array();
        $stmt = $this->dbh->query($this->buildMenuQuery($tree, $startModuleID, $siteID));
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
        $lastMenu = "<ul class='tree'>" . @array_pop($treeMenu) . "</ul>\n";
        return $lastMenu; 
    }

    /**
     * Create the admin link.
     * 
     * @param string $module 
     * @access public
     * @return string
     */
    public function createAdminLink($module)
    {
        if($module->tree == 'forum')
        {
            $moduleName = 'forum';
            $methodName = 'boardAdmin';
            $vars       = "moduleID=$module->id";
            $linkHtml   = html::a(helper::createLink($moduleName, $methodName, $vars), $module->name, 'mainwin', "id='module{$module->id}'");
            return $linkHtml;
        }
        elseif($module->tree == 'usercase')
        {
            $moduleName = 'usercase';
            $methodName = 'browseAdmin';
            $vars       = "moduleID=$module->id";
            $linkHtml   = html::a(helper::createLink($moduleName, $methodName, $vars), $module->name, 'mainwin', "id='module{$module->id}'");
            return $linkHtml;
        }
        elseif($module->tree == 'extension')
        {
            $moduleName = 'extension';
            $methodName = 'browseAdmin';
            $vars       = "moduleID=$module->id";
            $linkHtml   = html::a(helper::createLink($moduleName, $methodName, $vars), $module->name, 'mainwin', "id='module{$module->id}'");
            return $linkHtml;
        }
        elseif($module->tree == 'webapp')
        {
            $moduleName = 'webapp';
            $methodName = 'browseAdmin';
            $vars       = "moduleID=$module->id";
            $linkHtml   = html::a(helper::createLink($moduleName, $methodName, $vars), $module->name, 'mainwin', "id='module{$module->id}'");
            return $linkHtml;
        }
        elseif($module->tree == 'ask')
        {
            $moduleName = 'ask';
            $methodName = 'manageFAQ';
            $vars       = "moduleID=$module->id";
            $linkHtml   = html::a(helper::createLink($moduleName, $methodName, $vars), $module->name, 'mainwin', "id='module{$module->id}'");
            return $linkHtml;
        }
        elseif($module->tree == 'video')
        {
            $moduleName = 'video';
            $methodName = 'browseAdmin';
            $vars       = "moduleID=$module->id&tree=$module->tree";
            $linkHtml   = html::a(helper::createLink($moduleName, $methodName, $vars), $module->name, 'mainwin', "id='module{$module->id}'");
            return $linkHtml;
        }
        elseif($module->tree == 'guide')
        {
            if($module->grade != 2) return $module->name;   // only level two can create links.
            $moduleName = 'guide';
            $methodName = 'manage';
            $vars       = "moduleID=$module->id";
            $linkHtml   = html::a(helper::createLink($moduleName, $methodName, $vars), $module->name, 'mainwin', "id='module{$module->id}'");
            return $linkHtml;
        }
        else
        {
            $moduleName = 'article';
            $methodName = 'browseAdmin';
            $orderBy    = $module->tree == 'article' ? 'id_desc' : '`order`';
            $vars       = "tree=$module->tree&moduleID=$module->id&orderBy=$orderBy";
            $linkHtml   = html::a(helper::createLink($moduleName, $methodName, $vars), $module->name, 'mainwin', "id='module($module->id)'");
            return $linkHtml;
        }
        /* 
        *$moduleName = $module->tree == 'forum' ? 'forum' : 'article';
        $methodName = $module->tree == 'forum' ? 'boardAdmin' : 'browseAdmin';
        $vars       = $module->tree == 'forum' ? "moduleID=$module->id" : "tree=$module->tree&moduleID=$module->id";
        $linkHtml = html::a(helper::createLink($moduleName, $methodName, $vars), $module->name, 'mainwin', "id='module{$module->id}'");
        return $linkHtml;*/
    }

    /**
     * Create the browse link.
     * 
     * @param string $module 
     * @access private
     * @return string
     */
    public function createBrowseLink($module)
    {
        $linkHtml = html::a(helper::createLink('article', 'browse', "moduleID={$module->id}"), $module->name, '', "id='module{$module->id}'");
        return $linkHtml;
    }

    /**
     * Create the manage link.
     * 
     * @param string $module 
     * @access private
     * @return string
     */
    public function createManageLink($module)
    {
        $linkHtml  = $module->name;
        $linkHtml .= ' ' . html::a(helper::createLink('tree', 'edit',   "module={$module->id}&tree=$module->tree"), $this->lang->tree->edit, '', 'class="iframe"');
        $linkHtml .= ' ' . html::a(helper::createLink('tree', 'browse', "tree={$module->tree}&module={$module->id}"), $this->lang->tree->child);
        $linkHtml .= ' ' . html::a(helper::createLink('tree', 'delete', "module={$module->id}"), $this->lang->delete, 'hiddenwin');
        $linkHtml .= ' ' . html::input("orders[$module->id]", $module->order, 'style="width:30px;text-align:center"');
        return $linkHtml;
    }

    /**
     * Get son modules of one module.
     * 
     * @param string $moduleID 
     * @param string $tree 
     * @access public
     * @return array
     */
    public function getSons($moduleID, $tree = 'article')
    {
        return $this->dao->select('*')->from(TABLE_MODULE)
            ->where('parent')->eq((int)$moduleID)
            ->andWhere('tree')->eq($tree)
            ->orderBy('`order`')
            ->fetchAll();
    }
    
    /**
     * Get all child modules of one module.
     * 
     * @param string $moduleID 
     * @param string $tree 
     * @access public
     * @return array
     */
    public function getAllChildId($moduleID, $tree = '')
    {
        if($moduleID == 0 and empty($tree)) return array();
        $module = $this->getById($moduleID);

        if($module)  return $this->dao->select('id')->from(TABLE_MODULE)->where('path')->like($module->path . '%')->fetchPairs();
        if(!$module) return $this->dao->select('id')->from(TABLE_MODULE)->where('tree')->eq($tree)->fetchPairs();
    }

    /**
     * Get parent modules of on module.
     * 
     * @param string $moduleID 
     * @access public
     * @return array
     */
    public function getParents($moduleID)
    {
        if($moduleID == 0) return array();
        $path = $this->dao->select('path')->from(TABLE_MODULE)->where('id')->eq((int)$moduleID)->fetch('path');
        $path = trim($path, ',');
        if(!$path) return array();
        return $this->dao->select('*')->from(TABLE_MODULE)->where('id')->in($path)->orderBy('grade')->fetchAll();
    }

    /**
     * Update the order.
     * 
     * @param string $orders 
     * @access public
     * @return void
     */
    public function updateOrder($orders)
    {
        foreach($orders as $moduleID => $order)
        {
            $this->dao->update(TABLE_MODULE)->set('`order`')->eq($order)->where('id')->eq((int)$moduleID)->limit(1)->exec();
        }
    }

    /**
     * Manage childs of one module.
     * 
     * @param string $tree 
     * @param string $parentModuleID 
     * @param string $childs 
     * @access public
     * @return void
     */
    public function manageChild($tree, $parentModuleID, $childs)
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

    /**
     * Update a module.
     * 
     * @param string $moduleID 
     * @access public
     * @return void
     */
    public function update($moduleID)
    {
        if($this->post->tree == 'forum')
        {
            $parents = $this->post->parents;
            $sites   = $this->post->sites;
            $module  = fixer::input('post')->setDefault('readonly', 0)->specialChars('name')->remove('tree, parents, sites')->get();
            $oldModule = $this->dao->findById((int)$moduleID)->from(TABLE_MODULE)->fetch('');

            foreach($parents as $siteID => $parentID)
            {
                $parent = $this->dao->findById((int)$parentID)->from(TABLE_MODULE)->fetch('', false);
                $module->id             = $moduleID;
                $module->parent         = $parent ? $parent->id : 0;
                $module->site           = $sites[$siteID];
                $module->grade          = $parent ? $parent->grade + 1 : 1;
                $module->tree           = $this->post->tree;
                $module->order          = $oldModule->order;
                $module->threads        = $oldModule->threads;
                $module->posts          = $oldModule->posts;
                $module->lastPostedBy   = $oldModule->lastPostedBy; 
                $module->lastPostedDate = $oldModule->lastPostedDate; 
                $module->lastPostID     = $oldModule->lastPostID;
                $module->lastReplyID    = $oldModule->lastReplyID;

                $this->dao->delete()->from(TABLE_MODULE)->where('id')->eq($moduleID)->andWhere('site')->eq($module->site)->exec(false);
                if($parentID != '') $this->dao->insert(TABLE_MODULE)->data($module)->exec(false);
                $this->fixModulePath($module->tree);
            }
        }
        else
        {
            $module = fixer::input('post')->setDefault('readonly', 0)->specialChars('name')->get();
            $parent = $this->getById($this->post->parent);
            $module->grade = $parent ? $parent->grade + 1 : 1;

            $this->dao->update(TABLE_MODULE)->data($module)->autoCheck()->check('name', 'notempty')->where('id')->eq($moduleID)->exec();
            $this->fixModulePath($module->tree);
        }

        $childs = $this->getAllChildId($moduleID);
        $this->dao->update(TABLE_MODULE)->set('grade = grade + 1')->where('id')->in($childs)->andWhere('id')->ne($moduleID)->exec();
    }

    /**
     * Delete a module.
     * 
     * @param string $moduleID 
     * @access public
     * @return void
     */
    public function delete($moduleID)
    {
        $module = $this->getById($moduleID);
        $childs = $this->getAllChildId($moduleID);

        $this->dao->update(TABLE_MODULE)->set('grade = grade - 1')->where('id')->in($childs)->exec();                 // Update childs' grade.
        $this->dao->update(TABLE_MODULE)->set('parent')->eq($module->parent)->where('parent')->eq($moduleID)->exec(); // Update sons' parent to my parent.
        $this->dao->delete()->from(TABLE_MODULE)->where('id')->eq($moduleID)->exec();                                 // Delete my self.
        $this->fixModulePath($module->tree);

        if($module->tree == 'article') $this->dao->update(TABLE_ARTICLEMODULE)->set('module')->eq($module->parent)->where('module')->eq($moduleID)->exec();
    }

    /**
     * Fix the path, grade fields according to the id and parent fields.
     *
     * @param  string    $tree 
     * @access public
     * @return void
     */
    public function fixModulePath($tree)
    {
        /* Get all modules grouped by parent. */
        $groupModules = $this->dao->select('id, parent')->from(TABLE_MODULE)->where('tree')->eq($tree)->fetchGroup('parent', 'id');
        $modules = array();

        /* Cycle the groupModules until it has no item any more. */
        while(count($groupModules) > 0)
        {
            $oldCounts = count($groupModules);    // Record the counts before processing.
            foreach($groupModules as $parentModuleID => $childModules)
            {
                /* If the parentModule doesn't exsit in the modules, skip it. If exists, compute it's child modules. */
                if(!isset($modules[$parentModuleID]) and $parentModuleID != 0) continue;
                if($parentModuleID == 0)
                {
                    $parentModule->grade = 0;
                    $parentModule->path  = ',';
                }
                else
                {
                    $parentModule = $modules[$parentModuleID];
                }

                /* Compute it's child modules. */
                foreach($childModules as $childModuleID => $childModule)
                {
                    $childModule->grade = $parentModule->grade + 1;
                    $childModule->path  = $parentModule->path . $childModule->id . ',';
                    $modules[$childModuleID] = $childModule;    // Save child module to modules, thus the child of child can compute it's grade and path.
                }
                unset($groupModules[$parentModuleID]);    // Remove it from the groupModules.
            }
            if(count($groupModules) == $oldCounts) break;   // If after processing, no module processed, break the cycle.
        }

        /* Save modules to database. */
        foreach($modules as $module)
        {
            $this->dao->update(TABLE_MODULE)->data($module)->where('id')->eq($module->id)->limit(1)->exec();
        }
    }
}
