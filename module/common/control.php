<?php
/**
 * The control file of common module of XiRangEPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     common
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class common extends control
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
        $this->common->setUser();
        $this->loadModel('site')->setSite();
        $this->initRZ();
    }

    /**
     * initRZ 
     * 
     * @access public
     * @return void
     */
    public function initRZ()
    {
        if(RUN_MODE == 'cli') return;
        
        $referee = $this->get->u ? $this->get->u : (isset($_COOKIE['r']) ? $_COOKIE['r'] : '');
        if(!isset($_COOKIE['r']) or (isset($_COOKIE['r']) and $_COOKIE['r'] != $referee)) setcookie('r', $referee, time() + 31104000); 
        apache_note('referee', $referee); 

        $zcookie = isset($_COOKIE['z']) ? $_COOKIE['z'] : md5($_SERVER['REMOTE_ADDR'] . time());
        if(!isset($_COOKIE['z'])) setcookie('z', $zcookie, time() + 31104000); 
        apache_note('zcookie', $zcookie); 
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
     * Print the search form.
     * 
     * @access public
     * @return void
     */
    public function printSearch()
    {
        self::printXunSearch();
    }

    /**
     * Print the google search form
     * 
     * @param string $cx 
     * @access private
     * @return void
     */
    private function printGoogleSearch($cx)
    {
        global $lang;
        $action = helper::createLink('search', 'google');
        echo <<<EOT
        <form action='$action' id='cse-search-box'>
          <div>
            <input type='hidden' name='cx' value='$cx' />
            <input type='hidden' name='cof' value='FORID:9' />
            <input type='hidden' name='ie' value='UTF-8' />
            <input type='text' name='q' size='31' />
            <input type='submit' name='sa' value='$lang->search' />
            </div>
        </form>
        <script type='text/javascript' src='http://www.google.com/cse/brand?form=cse-search-box&lang=zh-Hans'></script>
EOT;
    }

    /**
     * Print the bing search form
     * 
     * @param  string    $appID 
     * @access private
     * @return void
     */
    private function printBingSearch($appID)
    {
        global $lang;
        $action = helper::createLink('search', 'bing');
 
        echo <<<EOT
        <form action='$action' method='post' id='cse-search-box'>
          <input type='text' name='key' size='31' />
          <input type='submit' name='sa' value=' ' />
        </form>
EOT;
    }

    /**
     * Print the bing search form
     * 
     * @param  string    $appID 
     * @access private
     * @return void
     */
    private function printXunSearch()
    {
        global $lang;
        $action = helper::createLink('search', 'xunSearch', "moduleName={$this->app->getModuleName()}");
        $key    = $this->session->key ? $this->session->key : '';

        echo <<<EOT
        <form action='$action' method='get' id='search-box'>
          <input type='text' name='key' size='31' value='$key'/>
          <input type='submit' name='sa' value=' ' />
        </form>
EOT;
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
}
