<?php
/**
 * The model file of common module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     common
 * @version     $Id$
 * @link        http://www.xirang.biz
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
                    $this->config->{$record->section}->{$record->key} = $record->value;
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
        if(RUN_MODE == 'front')
        {
            if(
                isset($config->front->groups->guest[$module]) 
                && in_array($method, $config->front->groups->guest[$module])
              ) return true;
              return isset($config->front->groups->user[$module]) && in_array($method, $this->config->front->groups->user[$module]);
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
     * Juage a method of one module is open or not?
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
     * Create the front main menu.
     * 
     * @static
     * @access public
     * @return string
     */
    
    public function createFrontMenu()
    {
        global $app, $lang;   
        $menus = $lang->frontMenu;
        $moduleName = $app->getModuleName();
        $methodName = $app->getMethodName();

        $string = '
            <div class="navbar">
              <div class="navbar-inner">
               <div class="container">
                 <ul class="nav">';

        foreach($menus as $menu)
        {
            list($label, $module, $method) = explode('|', $menu);
            $class   = ($module == $moduleName) && ($method == $methodName) ? ' class="active"' : ''; 
            $string .= "<li{$class}>" . html::a($this->createLink($module , $method) , $label) . '</li>';
        }
        
        $topCategories = $this->loadModel('tree')->getSons(0);
        foreach($topCategories as $category)
        {
            $string .= '<li>' . $this->loadModel('tree')->createBrowseLink($category) .'</li>';
        }
        $string .= "
                    </ul>
                  </div>
                </div>
              </div>";
        return $string;
    }
        
    /**
     * Create the main menu.
     * 
     * @param  string $moduleName 
     * @static
     * @access public
     * @return string
     */
    public static function createMainMenu($moduleName)
    {
        global $app, $lang;
        $string = "<ul class='nav'>\n";

        /* Get current menu. */
        $currentMenu = commonModel::getCurrentMenu($moduleName);
        /* Print all main menus. */
        foreach($lang->menu as $key => $menu)
        {
            $class = $key == $currentMenu ? " class='active'" : '';
            list($label, $module, $method, $vars) = explode('|', $menu);

            if(commonModel::hasPriv($module, $method))
            {
                $link  = helper::createLink($module, $method, $vars);
                $string .= "<li$class><a href='$link' id='menu$key'>$label</a></li>\n";
            }
        }
        $string .= "</ul>\n";
        return $string;
    }

    /**
     * get current menu module for mainmenu and moduleMenu
     *
     * @param  string $moduleName 
     * @static
     * @access public
     * @return string
     */
    public static function getCurrentMenu($moduleName)
    {
        global $app, $lang;
        $menuAlias  = $lang->menuAlias;
        $methodName = $app->getMethodName(); 
        if(isset($lang->menuMethodParamGroup["{$moduleName}.{$methodName}"]))
        {
            $paramSetting = $lang->menuMethodParamGroup["{$moduleName}.{$methodName}"];
            foreach($paramSetting as $paramKey => $paramGroups)
            {
                if(isset($_REQUEST[$paramKey])) return $paramGroups[$_REQUEST[$paramKey]];
            }
        }

        if(isset($lang->menuMethodGroup["{$moduleName}.{$methodName}"])) 
        return $lang->menuMethodGroup["{$moduleName}.{$methodName}"];

        if(isset($lang->menuModuleGroup[$moduleName])) return $lang->menuModuleGroup[$moduleName];

        return $moduleName;
    }

    /**
     * Create the module menu.
     * 
     * @param  string $moduleName 
     * @static
     * @access public
     * @return void
     */
    public static function createModuleMenu($moduleName)
    {
        global $lang, $app;
        
        $currentModule = $moduleName = commonModel::getCurrentMenu($moduleName);
        if(!isset($lang->$moduleName->menu)) return false;
        $string = "<ul class='nav nav-list leftmenu affix'>\n";

        /* Get the sub menus of the module, and get current module and method. */
        $submenus      = $lang->$moduleName->menu;  
        $currentModule = commonModel::getCurrentMenu($moduleName);
        $currentMethod = $app->getMethodName();
        /* Cycling to print every sub menus. */
        foreach($submenus as $key => $menu)
        {
            list($label, $module, $method, $vars) = explode('|', $menu);
            $label .= '<i class="icon-chevron-right"></i>';

            if(commonModel::hasPriv($module, $method))
            {
                $class = '';
                if($module == $app->getModuleName() && $method == $currentMethod) $class = " class='active'";
                if(
                    isset($lang->menuAlias["{$moduleName}.{$currentMethod}"])
                    && strpos($lang->menuAlias["{$moduleName}.{$currentMethod}"], ",{$module}.{$method},") !== false
                )
                $class = " class='active'";
                $string .= "<li{$class}>" . html::a(helper::createLink($module, $method, $vars), $label, '', "id='submenu$key'") . "</li>\n";
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
        global $app, $lang;

        $string  = '<p class="navbar-text pull-right">';
        $string .= sprintf($lang->welcome, $app->user->account);
        $string .= html::a(helper::createLink('user','logout'), $lang->logout, '', 'class="navbar-link"');
        $string .= html::a(getWebroot(), '<i class="icon-home icon-white"></i>'.$lang->frontHome, '_blank', 'class="navbar-link"');
        $string .= '</p>';

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
            printf($app->lang->welcome, $app->session->user->account);
            $messages = $dao->select('COUNT(*) as count')->from(TABLE_MESSAGE)->where('`to`')->eq($app->session->user->account)->andWhere('readed')->eq(0)->fetch('count', false);
            if($messages) echo html::a(helper::createLink('user', 'message'), sprintf($app->lang->messages, $messages));
            echo html::a(helper::createLink('user', 'control'), $app->lang->dashboard);
            echo $divider;
            echo html::a(helper::createLink('user', 'logout'),  $app->lang->logout);
            echo $divider;
        }    
        else
        {
            echo html::a(helper::createLink('user', 'login'),    $app->lang->login);
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
    public function printPositionBar($module = '', $object = '', $misc = '')
    {
        return ;
        echo '<ul class="breadcrumb">';
        echo '<li>' . html::a($this->config->webRoot, $this->config->site->name) . '</li>';
        $funcName = 'print' . $this->app->getModuleName();
        echo $this->$funcName($module, $object, $misc);
        echo '</ul>';
    }

    /**
     * Print the link contains orderBy field.
     *
     * This method will auto set the orderby param according the params. Fox example, if the order by is desc,
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
        if(empty($module)) $module= $app->getModuleName();
        if(empty($method)) $method= $app->getMethodName();
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
        $user           = new stdClass();
        $user->id       = 0;
        $user->account  = 'guest';
        $user->realname = 'guest';
        $user->admin    = RUN_MODE == 'cli' ? 'super' : 'no';

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
     * Print the positon bar of article module.
     * 
     * @param  object $module 
     * @param  object $article 
     * @access public
     * @return void
     */
    public function printcompany($module)
    {
        echo ' <span class="divider">/</span></li> ' . $this->lang->aboutUs; 
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
        foreach($module->pathNames as $moduleID => $moduleName) echo ' <span class="divider">/</span> ' . html::a(inlink('browse', "moduleID=$moduleID"), $moduleName);
        if($article) echo '<span class="divider">/</span>' . html::a(inlink('view', "id=$article->id"), $article->title);
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
        echo ' > ' . html::a(helper::createLink('forum', 'index'), $this->lang->position['forum']);
        if(!$board) return false;

        unset($board->pathNames[key($board->pathNames)]);
        foreach($board->pathNames as $boardID => $boardName) echo ' > ' . html::a(helper::createLink('forum', 'board', "boardID=$boardID"), $boardName);
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
        if($thread) echo ' > ' . html::a(inlink('view', "id=$thread->id"), $thread->title);
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
        echo " > {$this->lang->position['search']} > " . html::a(inlink('xunSearch', "module=$module") . "?key=$keywords", $keywords);
    }
}
