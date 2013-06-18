<?php
/**
 * The model file of common module of XiRangEPS.
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
        $this->setUser();
        $this->loadModel('site')->setSite();
    }

    /**
     * Check the priviledge.
     * 
     * @access public
     * @return void
     */
    public function checkPriv()
    {
        if(RUN_MODE == 'front') $this->common->checkFront();
        if(RUN_MODE == 'admin') $this->common->checkAdmin();
    }

   /**
     * Print the run info.
     * 
     * @param mixed $startTime  the start time.
     * @access public
     * @return void
     */
    public function printRunInfo($startTime)
    {
        vprintf($this->lang->runInfo, $this->common->getRunInfo($startTime));
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
        $divider = '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;';
        if($app->config->features->user)
        {
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
        echo "<ul class='u-1 nav'>";
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
        echo '<div class="row"><div class="u-1">';
        echo $this->lang->currentPos;
        echo html::a($this->config->webRoot, $this->app->site->name);
        $funcName = 'print' . $this->app->getModuleName();
        echo $this->common->$funcName($module, $object, $misc);
        echo '</div></div>';
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
        $user->isAdmin  = false;
        $user->isSuper  = false;

        if(RUN_MODE == 'cli')
        {
            $user->isSuper = true;
            $user->isAdmin = true;
        }

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
     * Check current user has priviledge to the module's method or not.
     * 
     * @todo add group priviledges.
     * @param mixed $module     the module
     * @param mixed $method     the method
     * @static
     * @access public
     * @return bool
     */
    public function hasPriv($module, $method)
    {
        return $this->app->user->isAdmin;
    }

    /**
     * Check the priviledge of front.
     * 
     * @access public
     * @return void
     */
    public function checkFront()
    {
        $module = $this->app->getModuleName();
        $method = $this->app->getMethodName();
        if(strpos($this->config->frontActions, $module . '-' . $method) === false) $this->deny($module, $method);
    }

    /**
     * Check the priviledge of admin.
     * 
     * @access public
     * @return void
     */
    public function checkAdmin()
    {
        $module = $this->app->getModuleName();
        $method = $this->app->getMethodName();

        /* The login, logout and deny page needn't check. */
        if($module == 'user' and strpos(',login|logout|deny|resetpassword|checkresetkey', $method)) return true;

        /* If the suer not login, try login use the PHP_AUTH_USER. */
        if($this->app->user->account == 'guest' and $this->server->php_auth_user and $this->server->php_auth_pw)
        {
            $account  = $this->server->php_auth_user;
            $password = $this->server->php_auth_pw;
            $user = $this->loadModel('user')->identify($account, $password);

            /* If identify passed, authorize the user and register it to app and session .*/
            if($user)
            {
                $this->session->set('user', $user);
                $this->app->user = $user;
            }
        }

        /* If no $app->user yet, go to the login pae. */
        if($this->app->user->account == 'guest')
        {
            $referer  = helper::safe64Encode($this->app->getURI(true));
            die(js::locate(helper::createLink('user', 'login', "referer=$referer&from=zentao")));
        }

        /* Check the priviledge. */
        if(!$this->hasPriv($module, $method)) $this->deny($module, $method);
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
     * Print the positon bar of article module.
     * 
     * @param  object $module 
     * @param  object $article 
     * @access public
     * @return void
     */
    public function printArticle($module, $article)
    {
        foreach($module->pathNames as $moduleID => $moduleName) echo ' > ' . html::a(inlink('browse', "moduleID=$moduleID"), $moduleName);
        if($article) echo ' > ' . html::a(inlink('view', "id=$article->id"), $article->title);
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
