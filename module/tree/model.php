<?php
/**
 * The model file of tree category of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
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
     * Get category info by id.
     * 
     * @param string $categoryID 
     * @access public
     * @return void
     */
    public function getByID($categoryID)
    {
        $category = $this->dao->findById((int)$categoryID)->from(TABLE_CATEGORY)->fetch();
        if(!$category) return $category;
        $pathNames   = $this->dao->select('id, name')->from(TABLE_CATEGORY)->where('id')->in($category->path)->orderBy('grade')->fetchPairs();
        $category->pathNames = $pathNames;
        return $category;
    }

    /**
     * Build the sql to execute.
     * 
     * @param string $tree              the tree type, for example, article|forum
     * @param int    $startCategoryID     the start category id
     * @param int    $siteID            the site id
     * @access public
     * @return string
     */
    public function buildMenuQuery($tree, $startCategoryID, $siteID = 0)
    {
        /* Get the start category path according the $startCategoryID. */
        $startCategoryPath = '';
        if($startCategoryID > 0)
        {
            $startCategory = $this->getById($startCategoryID);
            if($startCategory) $startCategoryPath = $startCategory->path . '%';
        }

        return $this->dao->select('*')->from(TABLE_CATEGORY)
            ->where('tree')->eq($tree)
            ->beginIF($startCategoryPath)->andWhere('path')->like($startCategoryPath)->fi()
            ->beginIF($siteID)->andWhere('site')->eq($siteID)->fi()
            ->orderBy('grade desc, `order`')
            ->get($siteID ? false : true);
    }

    /**
     * Create a tree menu in <select> tag.
     * 
     * @param string $tree 
     * @param int    $startCategoryID 
     * @param int    $siteID
     * @access public
     * @return string
     */
    public function getOptionMenu($tree = 'article', $startCategoryID = 0, $siteID = 0)
    {
        /* First, get all categories. */
        $treeMenu   = array();
        $stmt       = $this->dbh->query($this->buildMenuQuery($tree, $startCategoryID, $siteID));
        $categories = array();
        while($category = $stmt->fetch()) $categories[$category->id] = $category;

        /* Cycle them, build the select control.  */
        foreach($categories as $category)
        {
            $parentCategories = explode(',', $category->path);
            $categoryName     = '/';
            foreach($parentCategories as $parentCategoryID)
            {
                if(empty($parentCategoryID)) continue;
                $categoryName .= $categories[$parentCategoryID]->name . '/';
            }
            $categoryName = rtrim($categoryName, '/');
            $categoryName .= "|$category->id\n";

            if(isset($treeMenu[$category->id]) and !empty($treeMenu[$category->id]))
            {
                if(isset($treeMenu[$category->parent]))
                {
                    $treeMenu[$category->parent] .= $categoryName;
                }
                else
                {
                    $treeMenu[$category->parent] = $categoryName;;
                }
                $treeMenu[$category->parent] .= $treeMenu[$category->id];
            }
            else
            {
                if(isset($treeMenu[$category->parent]) and !empty($treeMenu[$category->parent]))
                {
                    $treeMenu[$category->parent] .= $categoryName;
                }
                else
                {
                    $treeMenu[$category->parent] = $categoryName;
                }    
            }
        }

        $topMenu = @array_pop($treeMenu);
        $topMenu = explode("\n", trim($topMenu));
        $lastMenu[] = '/';
        foreach($topMenu as $menu)
        {
            if(!strpos($menu, '|')) continue;
            $menu       = explode('|', $menu);
            $label      = array_shift($menu);
            $categoryID = array_pop($menu);
            if(!empty($menu) and $this->cookie->lang == 'en') $lable = '/' . $menu;
           
            $lastMenu[$categoryID] = $label;
        }
        return $lastMenu;
    }

    /**
     * Get the id => name pairs of some categories.
     * 
     * @param string $categories   the category lists
     * @param string $tree      the tree
     * @access public
     * @return array
     */
    public function getPairs($categories = '', $tree = '')
    {
        return $this->dao->select('id, name')->from(TABLE_CATEGORY)
            ->beginIF($categories)->where('id')->in($categories)->fi()
            ->beginIF($tree)->where('tree')->eq($tree)->fi()
            ->fetchPairs();
    }

    /**
     * Get the tree menu in <ul><ol> type.
     * 
     * @param string    $tree           the tree type
     * @param int       $startCategoryID  the start category
     * @param string    $userFunc       which function to be called to create the link
     * @access public
     * @return string   the html code of the tree menu.
     */
    public function getTreeMenu($tree = 'article', $startCategoryID = 0, $userFunc, $siteID = 0)
    {
        $treeMenu = array();
        $stmt = $this->dbh->query($this->buildMenuQuery($tree, $startCategoryID, $siteID));
        while($category = $stmt->fetch())
        {
            $linkHtml = call_user_func($userFunc, $category);

            if(isset($treeMenu[$category->id]) and !empty($treeMenu[$category->id]))
            {
                if(!isset($treeMenu[$category->parent])) $treeMenu[$category->parent] = '';
                $treeMenu[$category->parent] .= "<li>$linkHtml";  
                $treeMenu[$category->parent] .= "<ul>".$treeMenu[$category->id]."</ul>\n";
            }
            else
            {
                if(isset($treeMenu[$category->parent]) and !empty($treeMenu[$category->parent]))
                {
                    $treeMenu[$category->parent] .= "<li>$linkHtml\n";  
                }
                else
                {
                    $treeMenu[$category->parent] = "<li>$linkHtml\n";  
                }    
            }
            $treeMenu[$category->parent] .= "</li>\n"; 
        }
        $lastMenu = "<ul class='tree'>" . @array_pop($treeMenu) . "</ul>\n";
        return $lastMenu; 
    }

    /**
     * Create the admin link.
     * 
     * @param string $category 
     * @access public
     * @return string
     */
    public function createAdminLink($category)
    {
        if($category->tree == 'forum')
        {
            $categoryName = 'forum';
            $methodName   = 'boardAdmin';
            $vars         = "categoryID=$category->id";
            $linkHtml     = html::a(helper::createLink($categoryName, $methodName, $vars), $category->name, 'mainwin', "id='category{$category->id}'");
            return $linkHtml;
        }
        elseif($category->tree == 'usercase')
        {
            $categoryName = 'usercase';
            $methodName   = 'browseAdmin';
            $vars         = "categoryID=$category->id";
            $linkHtml     = html::a(helper::createLink($categoryName, $methodName, $vars), $category->name, 'mainwin', "id='category{$category->id}'");
            return $linkHtml;
        }
        elseif($category->tree == 'extension')
        {
            $categoryName = 'extension';
            $methodName   = 'browseAdmin';
            $vars         = "categoryID=$category->id";
            $linkHtml     = html::a(helper::createLink($categoryName, $methodName, $vars), $category->name, 'mainwin', "id='category{$category->id}'");
            return $linkHtml;
        }
        elseif($category->tree == 'webapp')
        {
            $categoryName = 'webapp';
            $methodName   = 'browseAdmin';
            $vars         = "categoryID=$category->id";
            $linkHtml     = html::a(helper::createLink($categoryName, $methodName, $vars), $category->name, 'mainwin', "id='category{$category->id}'");
            return $linkHtml;
        }
        elseif($category->tree == 'ask')
        {
            $categoryName = 'ask';
            $methodName   = 'manageFAQ';
            $vars         = "categoryID=$category->id";
            $linkHtml     = html::a(helper::createLink($categoryName, $methodName, $vars), $category->name, 'mainwin', "id='category{$category->id}'");
            return $linkHtml;
        }
        elseif($category->tree == 'video')
        {
            $categoryName = 'video';
            $methodName   = 'browseAdmin';
            $vars         = "categoryID=$category->id&tree=$category->tree";
            $linkHtml     = html::a(helper::createLink($categoryName, $methodName, $vars), $category->name, 'mainwin', "id='category{$category->id}'");
            return $linkHtml;
        }
        elseif($category->tree == 'guide')
        {
            if($category->grade != 2) return $category->name;   // only level two can create links.
            $categoryName = 'guide';
            $methodName   = 'manage';
            $vars         = "categoryID=$category->id";
            $linkHtml     = html::a(helper::createLink($categoryName, $methodName, $vars), $category->name, 'mainwin', "id='category{$category->id}'");
            return $linkHtml;
        }
        else
        {
            $categoryName = 'article';
            $methodName   = 'browseAdmin';
            $orderBy      = $category->tree == 'article' ? 'id_desc' : '`order`';
            $vars         = "tree=$category->tree&categoryID=$category->id&orderBy=$orderBy";
            $linkHtml     = html::a(helper::createLink($categoryName, $methodName, $vars), $category->name, 'mainwin', "id='category($category->id)'");
            return $linkHtml;
        }
        /* 
        *$categoryName = $category->tree == 'forum' ? 'forum' : 'article';
        $methodName    = $category->tree == 'forum' ? 'boardAdmin' : 'browseAdmin';
        $vars          = $category->tree == 'forum' ? "categoryID=$category->id" : "tree=$category->tree&categoryID=$category->id";
        $linkHtml      = html::a(helper::createLink($categoryName, $methodName, $vars), $category->name, 'mainwin', "id='category{$category->id}'");
        return $linkHtml;*/
    }

    /**
     * Create the browse link.
     * 
     * @param string $category 
     * @access private
     * @return string
     */
    public function createBrowseLink($category)
    {
        $linkHtml = html::a(helper::createLink('article', 'browse', "categoryID={$category->id}"), $category->name, '', "id='category{$category->id}'");
        return $linkHtml;
    }

    /**
     * Create the manage link.
     * 
     * @param string $category 
     * @access private
     * @return string
     */
    public function createManageLink($category)
    {
        $linkHtml  = $category->name;
        $linkHtml .= ' ' . html::a(helper::createLink('tree', 'edit',   "category={$category->id}&tree=$category->tree"), $this->lang->tree->edit, '', 'class="iframe"');
        $linkHtml .= ' ' . html::a(helper::createLink('tree', 'manageChild', "tree={$category->tree}&category={$category->id}"), $this->lang->tree->child, '', 'class="iframe"');
        $linkHtml .= ' ' . html::a(helper::createLink('tree', 'delete', "category={$category->id}"), $this->lang->delete, '', 'class="delete"');
        $linkHtml .= ' ' . html::input("orders[$category->id]", $category->order);
        return $linkHtml;
    }

    /**
     * Get son categories of one category.
     * 
     * @param string $categoryID 
     * @param string $tree 
     * @access public
     * @return array
     */
    public function getSons($categoryID, $tree = 'article')
    {
        return $this->dao->select('*')->from(TABLE_CATEGORY)
            ->where('parent')->eq((int)$categoryID)
            ->andWhere('tree')->eq($tree)
            ->orderBy('`order`')
            ->fetchAll();
    }
    
    /**
     * Get all child categories of one category.
     * 
     * @param string $categoryID 
     * @param string $tree 
     * @access public
     * @return array
     */
    public function getAllChildId($categoryID, $tree = '')
    {
        if($categoryID == 0 and empty($tree)) return array();
        $category = $this->getById($categoryID);

        if($category)  return $this->dao->select('id')->from(TABLE_CATEGORY)->where('path')->like($category->path . '%')->fetchPairs();
        if(!$category) return $this->dao->select('id')->from(TABLE_CATEGORY)->where('tree')->eq($tree)->fetchPairs();
    }

    /**
     * Get parent categories of on category.
     * 
     * @param string $categoryID 
     * @access public
     * @return array
     */
    public function getParents($categoryID)
    {
        if($categoryID == 0) return array();
        $path = $this->dao->select('path')->from(TABLE_CATEGORY)->where('id')->eq((int)$categoryID)->fetch('path');
        $path = trim($path, ',');
        if(!$path) return array();
        return $this->dao->select('*')->from(TABLE_CATEGORY)->where('id')->in($path)->orderBy('grade')->fetchAll();
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
        foreach($orders as $categoryID => $order)
        {
            $this->dao->update(TABLE_CATEGORY)->set('`order`')->eq($order)->where('id')->eq((int)$categoryID)->limit(1)->exec();
        }
    }

    /**
     * Manage childs of one category.
     * 
     * @param string $tree 
     * @param string $parentCategoryID 
     * @param string $childs 
     * @access public
     * @return void
     */
    public function manageChild($tree, $parentCategoryID, $childs)
    {
        $parentCategory = $this->getByID($parentCategoryID);
        if($parentCategory)
        {
            $grade      = $parentCategory->grade + 1;
            $parentPath = $parentCategory->path;
        }
        else
        {
            $grade      = 1;
            $parentPath = ',';
        }

        $i = 1;
        foreach($childs as $categoryID => $categoryName)
        {
            if(empty($categoryName)) continue;
            /* The new category. */
            if(is_numeric($categoryID))
            {
                $category = new stdClass();
                $category->id      = $this->dao->select('MAX(id) as id')->from(TABLE_CATEGORY)->fetch('id', false);
                $category->id      = (int)($category->id) + 1;
                $category->name    = $categoryName;
                $category->parent  = $parentCategoryID;
                $category->grade   = $grade;
                $category->tree    = $tree;
                $category->owners  = $this->app->user->account;
                $category->order   = $this->post->maxOrder + $i * 10;
                $category->path    = $parentPath . "$category->id,";
                $this->dao->insert(TABLE_CATEGORY)->data($category)->exec();
                $i ++;
            }
            /* The exisiting category. */
            else
            {
                $categoryID = str_replace('id', '', $categoryID);
                $this->dao->update(TABLE_CATEGORY)->set('name')->eq($categoryName)->where('id')->eq($categoryID)->exec();
            }
        }
        return !dao::isError();
    }

    /**
     * Update a category.
     * 
     * @param string $categoryID 
     * @access public
     * @return void
     */
    public function update($categoryID)
    {
        $category = fixer::input('post')->setDefault('readonly', 0)->specialChars('name')->get();
        $parent   = $this->getById($this->post->parent);
        $category->grade = $parent ? $parent->grade + 1 : 1;

        $this->dao->update(TABLE_CATEGORY)->data($category)->autoCheck()->check('name', 'notempty')->where('id')->eq($categoryID)->exec();
        $this->fixCategoryPath($category->tree);

        $childs = $this->getAllChildId($categoryID);
        $this->dao->update(TABLE_CATEGORY)->set('grade = grade + 1')->where('id')->in($childs)->andWhere('id')->ne($categoryID)->exec();
        return !dao::isError();
    }

    /**
     * Delete a category.
     * 
     * @param string $categoryID 
     * @access public
     * @return void
     */
    public function delete($categoryID)
    {
        $category = $this->getById($categoryID);
        $childs   = $this->getAllChildId($categoryID);

        $this->dao->update(TABLE_CATEGORY)->set('grade = grade - 1')->where('id')->in($childs)->exec();                 // Update childs' grade.
        $this->dao->update(TABLE_CATEGORY)->set('parent')->eq($category->parent)->where('parent')->eq($categoryID)->exec(); // Update sons' parent to my parent.
        $this->dao->delete()->from(TABLE_CATEGORY)->where('id')->eq($categoryID)->exec();                                 // Delete my self.
        $this->fixCategoryPath($category->tree);

        if($category->tree == 'article') $this->dao->update(TABLE_ARTICLECATEGORY)->set('category')->eq($category->parent)->where('category')->eq($categoryID)->exec();
        return !dao::isError();
    }

    /**
     * Fix the path, grade fields according to the id and parent fields.
     *
     * @param  string    $tree 
     * @access public
     * @return void
     */
    public function fixCategoryPath($tree)
    {
        /* Get all categories grouped by parent. */
        $groupCategories = $this->dao->select('id, parent')->from(TABLE_CATEGORY)->where('tree')->eq($tree)->fetchGroup('parent', 'id');
        $categories = array();

        /* Cycle the groupCategories until it has no item any more. */
        while(count($groupCategories) > 0)
        {
            $oldCounts = count($groupCategories);    // Record the counts before processing.
            foreach($groupCategories as $parentCategoryID => $childCategories)
            {
                /* If the parentCategory doesn't exsit in the categories, skip it. If exists, compute it's child categories. */
                if(!isset($categories[$parentCategoryID]) and $parentCategoryID != 0) continue;
                if($parentCategoryID == 0)
                {
                    $parentCategory = new stdClass();
                    $parentCategory->grade = 0;
                    $parentCategory->path  = ',';
                }
                else
                {
                    $parentCategory = $categories[$parentCategoryID];
                }

                /* Compute it's child categories. */
                foreach($childCategories as $childCategoryID => $childCategory)
                {
                    $childCategory->grade = $parentCategory->grade + 1;
                    $childCategory->path  = $parentCategory->path . $childCategory->id . ',';
                    $categories[$childCategoryID] = $childCategory;    // Save child category to categories, thus the child of child can compute it's grade and path.
                }
                unset($groupCategories[$parentCategoryID]);    // Remove it from the groupCategories.
            }
            if(count($groupCategories) == $oldCounts) break;   // If after processing, no category processed, break the cycle.
        }

        /* Save categories to database. */
        foreach($categories as $category)
        {
            $this->dao->update(TABLE_CATEGORY)->data($category)->where('id')->eq($category->id)->limit(1)->exec();
        }
    }
        

    /**
     * Validate an category.
     * 
     * @access public
     * @return object
     */
    public function validate($category)
    {
        $error = array();
        if(!is_numeric($this->post->parent))
        {
            $error['parent'] = sprintf($this->lang->error->int[0], $this->lang->tree->parent);
        }
        if($this->post->parent == $category) 
        {
            $error['parent'] = sprintf($this->lang->error->parentNotEqSelf, $this->lang->category->parent);
        }
        if(empty($_POST['name']))
        {
            $error['name'] = sprintf($this->lang->error->notempty, $this->lang->category->name);
        }
        return (array)$error;
    }

}
