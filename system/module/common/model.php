<?php
/**
 * The model file of common module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     common
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class commonModel extends model
{
    /**
     * Do some init functions.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->startSession();
        $this->setUser();
        $this->loadConfigFromDB();
        $this->loadModel('site')->setSite();
    }

    /**
     * Load configs from database and save it to config->system and config->personal.
     * 
     * @access public
     * @return void
     */
    public function loadConfigFromDB()
    {
        /* Get configs of system and current user. */
        $account = isset($this->app->user->account) ? $this->app->user->account : '';
        if($this->config->db->name) $config  = $this->loadModel('setting')->getSysAndPersonalConfig($account);
        $this->config->system   = isset($config['system']) ? $config['system'] : array();
        $this->config->personal = isset($config[$account]) ? $config[$account] : array();

        /* Overide the items defined in config/config.php and config/my.php. */
        if(isset($this->config->system->common))
        {
            foreach($this->config->system->common as $record)
            {   
                if($record->section)
                {
                    if(!isset($this->config->{$record->section})) $this->config->{$record->section} = new stdclass();
                    if($record->key) $this->config->{$record->section}->{$record->key} = $record->value;
                }
                else
                {
                    if(!$record->section) $this->config->{$record->key} = $record->value;
                }
            }
        }
    }

    /**
     * Start the session.
     * 
     * @access public
     * @return void
     */
    public function startSession()
    {
        $sessionName = RUN_MODE == 'front' ? 'frontsid' : 'adminsid';
        session_name($sessionName);
        if(!isset($_SESSION)) session_start();
    }

    /**
     * Check the priviledge.
     * 
     * @access public
     * @return void
     */
    public function checkPriv()
    {
        $module = $this->app->getModuleName();
        $method = $this->app->getMethodName();

        if($this->isOpenMethod($module, $method)) return true;

        /* If no $app->user yet, go to the login pae. */
        if(RUN_MODE == 'admin' and $this->app->user->account == 'guest')
        {
            $referer  = helper::safe64Encode($this->app->getURI(true));
            die(js::locate(helper::createLink('user', 'login', "referer=$referer")));
        }

        /* Check the priviledge. */
        if(!commonModel::hasPriv($module, $method)) $this->deny($module, $method);
    }

    /**
     * Check current user has priviledge to the module's method or not.
     * 
     * @param mixed $module     the module
     * @param mixed $method     the method
     * @static
     * @access public
     * @return bool
     */
    public static function hasPriv($module, $method)
    {
        global $app, $config;

        if(RUN_MODE == 'admin')
        {
            if($app->user->admin == 'no')    return false;
            if($app->user->admin == 'super') return true;
        }

        $rights  = $app->user->rights;
        if(isset($rights[strtolower($module)][strtolower($method)])) return true;
        return false;
    }

    /**
     * Show the deny info.
     * 
     * @param mixed $module     the module
     * @param mixed $method     the method
     * @access private
     * @return void
     */
    private function deny($module, $method)
    {
        $vars = "module=$module&method=$method";
        if(isset($_SERVER['HTTP_REFERER']))
        {
            $referer  = helper::safe64Encode($_SERVER['HTTP_REFERER']);
            $vars .= "&referer=$referer";
        }
        $denyLink = helper::createLink('user', 'deny', $vars);
        die(js::locate($denyLink));
    }

    /** 
     * Judge a method of one module is open or not?
     * 
     * @param  string $module 
     * @param  string $method 
     * @access public
     * @return bool
     */
    public function isOpenMethod($module, $method)
    {   
        if($module == 'user' and strpos(',login|logout|deny|resetpassword|checkresetkey', $method)) return true;
        if($module == 'api'  and $method == 'getsessionid') return true;

        if($this->loadModel('user')->isLogon() and stripos($method, 'ajax') !== false) return true;

        return false;
    }   

    /**
     * Create the main menu.
     * 
     * @param  string $currentModule 
     * @static
     * @access public
     * @return string
     */
    public static function createMainMenu($currentModule)
    {
        global $app, $lang;

        /* Set current module. */
        if(isset($lang->menuGroups->$currentModule)) $currentModule = $lang->menuGroups->$currentModule;

        $string = "<ul class='nav navbar-nav'>\n";

        /* Print all main menus. */
        foreach($lang->menu as $moduleName => $moduleMenu)
        {
            $class = $moduleName == $currentModule ? " class='active'" : '';
            list($label, $module, $method, $vars) = explode('|', $moduleMenu);
            if(commonModel::hasPriv($module, $method))
            {
                $link  = helper::createLink($module, $method, $vars);
                $string .= "<li$class><a href='$link'>$label</a></li>\n";
            }
        }

        $string .= "</ul>\n";
        return $string;
    }

    /**
     * Create the module menu.
     * 
     * @param  string $currentModule 
     * @static
     * @access public
     * @return void
     */
    public static function createModuleMenu($currentModule)
    {
        global $lang, $app;

        if(!isset($lang->$currentModule->menu)) return false;

        $string = "<ul class='nav nav-list leftmenu affix'>\n";

        /* Get menus of current module and current method. */
        $moduleMenus   = $lang->$currentModule->menu;  
        $currentMethod = $app->getMethodName();

        /* Cycling to print every menus of current module. */
        foreach($moduleMenus as $methodName => $methodMenu)
        {
            if(is_array($methodMenu)) 
            {
                $methodAlias = $methodMenu['alias'];
                $methodLink  = $methodMenu['link'];
            }
            else
            {
                $methodAlias = '';
                $methodLink  = $methodMenu;
            }

            /* Split the methodLink to label, module, method, vars. */
            list($label, $module, $method, $vars) = explode('|', $methodLink);
            $label .= '<i class="icon-chevron-right"></i>';

            if(commonModel::hasPriv($module, $method))
            {
                $class = '';
                if($module == $currentModule && $method == $currentMethod) $class = " class='active'";
                if($module == $currentModule && strpos($methodAlias, $currentMethod) !== false) $class = " class='active'";
                $string .= "<li{$class}>" . html::a(helper::createLink($module, $method, $vars), $label) . "</li>\n";
            }
        }

        $string .= "</ul>\n";
        return $string;
    }

    /**
     * Create menu for managers.
     * 
     * @access public
     * @return string
     */
    public static function createManagerMenu()
    {
        global $app, $lang , $config;

        $string  = '<ul class="nav navbar-nav navbar-right">';
        $string .= sprintf('<li>%s</li>', html::a($config->webRoot, '<i class="icon-home icon-large"></i> ' . $lang->frontHome, '_blank', 'class="navbar-link"'));
        $string .= sprintf('<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-large"></i> %s <b class="caret"></b></a>', $app->user->realname);
        $string .= sprintf('<ul class="dropdown-menu"><li>%s</li><li>%s</li></ul>', html::a(helper::createLink('user', 'changePassword'), $lang->changePassword, '', "data-toggle='modal'"), html::a(helper::createLink('user','logout'), $lang->logout, ''));
        $string .= '</li></ul>';

        return $string;
    }

    /**
     * Print the top bar.
     * 
     * @access public
     * @return void
     */
    public static function printTopBar()
    {
        global $app, $dao;
        $divider = '&nbsp;|&nbsp;';
        if($app->session->user->account != 'guest')
        {
            printf($app->lang->welcome, $app->session->user->realname);
            $messages = $dao->select('COUNT(*) as count')->from(TABLE_MESSAGE)->where('`to`')->eq($app->session->user->account)->andWhere('readed')->eq(0)->fetch('count', false);
            if($messages) echo html::a(helper::createLink('user', 'message'), sprintf($app->lang->messages, $messages));
            echo html::a(helper::createLink('user', 'control'), $app->lang->dashboard);
            echo $divider;
            echo html::a(helper::createLink('user', 'logout'),  $app->lang->logout);
        }    
        else
        {
            echo html::a(helper::createLink('user', 'login'), $app->lang->login);
            echo $divider;
            echo html::a(helper::createLink('user', 'register'), $app->lang->register);
        }    
    }

    /**
     * Print the nav bar.
     * 
     * @static
     * @access public
     * @return void
     */
    public static function printNavBar()
    {
        global $app;
        echo "<ul class='nav'>";
        echo '<li>' . html::a($app->config->webRoot, $app->lang->homePage) . '</li>';
        foreach($app->site->menuLinks as $menu) echo "<li>$menu</li>";
        echo '</ul>';
    }

    /**
     * Print position bar 
     *
     * @param   object $module 
     * @param   object $object 
     * @param   mixed  $misc    other params. 
     * @access  public
     * @return  void
     */
    public function printPositionBar($module = '', $object = '', $misc = '', $root = '')
    {
        echo '<ul class="breadcrumb">';
        if($root == '')
        {
            echo '<li>' . $this->lang->currentPos . $this->lang->colon . html::a($this->config->webRoot, $this->lang->home) . '</li>';
        }
        else
        {
            echo $root;
        }

        $moduleName = $this->app->getModuleName();
        $moduleName = $moduleName == 'reply' ? 'thread' : $moduleName;
        $funcName = "print$moduleName";
        echo $this->$funcName($module, $object, $misc);
        echo '</ul>';
    }
    
    /**
     * Print the link contains orderBy field.
     *
     * This method will auto set the orderby param according the params. For example, if the order by is desc,
     * will be changed to asc.
     *
     * @param  string $fieldName    the field name to sort by
     * @param  string $orderBy      the order by string
     * @param  string $vars         the vars to be passed
     * @param  string $label        the label of the link
     * @param  string $module       the module name
     * @param  string $method       the method name
     * @static
     * @access public
     * @return void
     */
    public static function printOrderLink($fieldName, $orderBy, $vars, $label, $module = '', $method = '')
    {
        global $lang, $app;
        if(empty($module)) $module = $app->getModuleName();
        if(empty($method)) $method = $app->getMethodName();
        $className = 'header';

        if(strpos($orderBy, $fieldName) !== false)
        {
            if(stripos($orderBy, 'desc') !== false)
            {
                $orderBy   = str_ireplace('desc', 'asc', $orderBy);
                $className = 'headerSortUp';
            }
            elseif(stripos($orderBy, 'asc')  !== false)
            {
                $orderBy = str_ireplace('asc', 'desc', $orderBy);
                $className = 'headerSortDown';
            }
        }
        else
        {
            $orderBy   = $fieldName . '_' . 'asc';
            $className = 'header';
        }

        $link = helper::createLink($module, $method, sprintf($vars, $orderBy));
        echo "<div class='$className'>" . html::a($link, $label) . '</div>';
    }

    /**
     * Set the user info.
     * 
     * @access public
     * @return void
     */
    public function setUser()
    {
        if($this->session->user) return $this->app->user = $this->session->user;

        /* Create a guest account. */
        $user           = new stdclass();
        $user->id       = 0;
        $user->account  = 'guest';
        $user->realname = 'guest';
        $user->admin    = RUN_MODE == 'cli' ? 'super' : 'no';
        $user->rights   = $this->config->rights->guest;

        $this->session->set('user', $user);
        $this->app->user = $this->session->user;
    }

    /**
     * Get the run info.
     * 
     * @param mixed $startTime  the start time of this execution
     * @access public
     * @return array    the run info array.
     */
    public function getRunInfo($startTime)
    {
        $info['timeUsed'] = round(getTime() - $startTime, 4) * 1000;
        $info['memory']   = round(memory_get_peak_usage() / 1024, 1);
        $info['querys']   = count(dao::$querys);
        return $info;
    }

    /**
     * Get the full url of the system.
     * 
     * @access public
     * @return string
     */
    public function getSysURL()
    {
        global $config;
        $httpType = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == 'on' ? 'https' : 'http';
        $httpHost = $_SERVER['HTTP_HOST'];
        return "$httpType://$httpHost";
    }

    /**
     * Get client IP.
     * 
     * @access public
     * @return void
     */
    public function getIP()
    {
        if(getenv("HTTP_CLIENT_IP"))
        {
            $ip = getenv("HTTP_CLIENT_IP");
        }
        elseif(getenv("HTTP_X_FORWARDED_FOR"))
        {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        }
        elseif(getenv("REMOTE_ADDR"))
        {
            $ip = getenv("REMOTE_ADDR");
        }
        else
        {
            $ip = "Unknow";
        }

        return $ip;
    }

    /**
     * Print the positon bar of product module.
     * 
     * @param  object $module 
     * @param  object $product 
     * @access public
     * @return void
     */
    public function printProduct($module, $product)
    {
        foreach($module->pathNames as $moduleID => $moduleName)
        {
            echo '<li>' . html::a(inlink('browse', "moduleID=$moduleID"), $moduleName) . '</li>';
        }
        if($product) echo '<li>' . html::a(inlink('view', "id=$product->id"), $product->name) . '</li>';
    }

    /**
     * Print the positon bar of company module.
     * 
     * @param  object $module 
     * @access public
     * @return void
     */
    public function printcompany($module)
    {
        echo '<li>' . $this->lang->aboutUs . '</li>'; 
    }

    /**
     * Print the positon bar of article module.
     * 
     * @param  object $module 
     * @param  object $article 
     * @access public
     * @return void
     */
    public function printArticle($module, $article)
    {
        $divider = $this->lang->divider;

        foreach($module->pathNames as $moduleID => $moduleName)
        {
            echo '<li>' . html::a(inlink('browse', "moduleID=$moduleID"), $moduleName) . '</li>';
        }
        if($article) echo '<li>' . html::a(inlink('view', "id=$article->id"), $article->title) . '</li>';
    }

    /**
     * Print the positon bar of article module.
     * 
     * @param  object $module 
     * @param  object $article 
     * @access public
     * @return void
     */
    public function printBlog($module, $article)
    {
        $divider = $this->lang->divider;

        foreach($module->pathNames as $moduleID => $moduleName)
        {
            echo '<li>' . html::a(inlink('index', "moduleID=$moduleID"), $moduleName) . '</li>';
        }
        if($article) echo '<li>' . html::a(inlink('view', "id=$article->id"), $article->title) . '</li>';
    }

    /**
     * Print the position bar of help module.
     * 
     * @param   object $book 
     * @access  public
     * @return  void
     */
    public function printHelp($category = '', $article = '')
    {
        echo '<li>' . html::a(helper::createLink('help', 'index'), $this->lang->helpHome) . '</li>';
        echo '<li>' . html::a(helper::createLink('help', 'book', "type=$category->code"), $category->book) . '</li>';
        foreach($category->pathNames as $categoryID => $categoryName)
        {
            echo '<li>' . html::a(helper::createLink('help', 'book', "type=$category->code&categoryID=$categoryID"), $categoryName) . '</li>';
        }
        if($article) echo '<li>' . html::a(inlink('read', "id=$article->id"), $article->title) . '</li>';
    }

    /**
     * Print the position bar of forum module.
     * 
     * @param   object $board 
     * @access  public
     * @return  void
     */
    public function printForum($board = '')
    {
        $divider = $this->lang->divider;
        echo '<li>' . html::a(helper::createLink('forum', 'index'), $this->lang->forumHome) . '</li>';
        if(!$board) return false;

        unset($board->pathNames[key($board->pathNames)]);
        foreach($board->pathNames as $boardID => $boardName)
        {
            echo '<li>' . html::a(helper::createLink('forum', 'board', "boardID=$boardID"), $boardName) . '</li>';
        }
    }

    /**
     * Print the position bar of thread module.
     * 
     * @param   object $board 
     * @param   object $thread 
     * @access  public
     * @return  void
     */
    public function printThread($board, $thread = '')
    {
        $this->printForum($board);
        if($thread) echo '<li>' . html::a(inlink('view', "id=$thread->id"), $thread->title) . '</li>';
    }

    /**
     * Print the position bar of Search. 
     * 
     * @param  int    $module 
     * @param  int    $object 
     * @param  int    $keywords 
     * @access public
     * @return void
     */
    public function printSearch($module, $object, $keywords)
    {
        echo "<li> {$this->lang->position['search']} > " . html::a(inlink('xunSearch', "module=$module") . "?key=$keywords", $keywords);
    }

    /**
     * Create front link for admin MODEL.
     *
     * @param string       $module
     * @param string       $method
     * @param string|array $vars
     * return string 
     */
    public static function createFrontLink($module, $method, $vars = '')
    {
        if(RUN_MODE == 'front') return helper::createLink($module, $method, $vars);

        global $config;

        $config->requestType = $config->frontRequestType;
        $link = helper::createLink($module, $method, $vars);
        $link = str_replace('admin.php', 'index.php', $link);
        $config->requestType = 'GET';

        return $link;
    }
}
