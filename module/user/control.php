<?php
/**
 * The control file of user module of XiRangBPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class user extends control
{
    /**
     * The referer
     * 
     * @var string
     * @access private
     */
    private $referer;

    /**
     * Register a user. 
     * 
     * @access public
     * @return void
     */
    public function register()
    {
        if(!empty($_POST))
        {
            $this->user->create();
            if(dao::isError()) die(js::error(dao::getError()));
            echo js::alert($this->lang->user->lblRegistered);
            $user = $this->user->identify($this->post->account, $this->post->password1);
            if($user)
            {
                $this->session->set('user', $user);
                $this->app->user = $this->session->user;
                $url = $this->post->referer ? urldecode($this->post->referer) : inlink('user', 'control');
                die(js::locate($url, 'parent'));
            }
            die(js::locate($this->createLink('index', 'index'), 'parent'));
        }

        /* Set the referer. */
        if(!isset($_SERVER['HTTP_REFERER']) or 
            strpos($_SERVER['HTTP_REFERER'], $this->app->site->domain) == false or 
            strpos($_SERVER['HTTP_REFERER'], 'login.php') != false)
        {
            $referer = urlencode('http://' . $this->app->site->domain . '/' . $this->config->webRoot);
        }
        else
        {
            $referer = urlencode($_SERVER['HTTP_REFERER']);
        }

        $this->view->referer = $referer;
        $this->display();
    }

    /**
     * Login.
     * 
     * @param string $referer 
     * @access public
     * @return void
     */
    public function login($referer = '')
    {
        $this->setReferer($referer);

        $loginLink = $this->createLink('user', 'login');
        $denyLink  = $this->createLink('user', 'deny');
        $regLink   = $this->createLink('user', 'register');

        /* If the user logon already, goto the pre page. */
        if($this->user->isLogon())
        {
            if(strpos($this->referer, $loginLink) === false and 
               strpos($this->referer, $denyLink)  === false and 
               strpos($this->referer, $regLink)   === false
            )
            {
                $this->locate($this->referer);
            }
            else
            {
                $this->locate($this->createLink($this->config->default->module));
            }
        }

        /* If the user sumbit post, check the user and then authorize him. */
        if(!empty($_POST))
        {
            $user = $this->user->identify($this->post->account, $this->post->password);
            if($user)
            {
                /* Register the session. */
                $this->session->set('user', $user);
                $this->app->user = $this->session->user;
                /* Admin mode, goto the default module directly. */
                if(RUN_MODE == 'admin') jsonReturn(1, '', '', $this->createLink($this->config->default->module));
                   // die(js::locate(, 'parent'));

                /* Goto the referer or to the default module */
                if($this->post->referer != false and 
                   strpos($this->post->referer, $loginLink) === false and 
                   strpos($this->post->referer, $denyLink)  === false and 
                   strpos($this->post->referer, $regLink)   === false
                )
                {
                    jsonReturn(1, '', '', urldecode($_POST['referer']));
                }
                else
                {
                    jsonReturn(1, '', '', $this->createLink('user', 'control'));
                }
            }
            else
            {
                jsonReturn(0, $this->lang->user->loginFailed);
            }
        }

        $this->view->header->title = $this->lang->user->login->common;
        $this->view->referer       = $this->referer;
        $this->display();
    }

    /**
     * logout 
     * 
     * @param int $referer 
     * @access public
     * @return void
     */
    public function logout($referer = 0)
    {
        session_destroy();
        $vars = !empty($referer) ? "referer=$referer" : '';
        $this->locate($this->createLink('user', 'login', $vars));
    }

    /**
     * The deny page.
     * 
     * @param mixed $module             the denied module
     * @param mixed $method             the deinied method
     * @param string $refererBeforeDeny the referer of the denied page.
     * @access public
     * @return void
     */
    public function deny($module, $method, $refererBeforeDeny = '')
    {
        $this->app->loadLang($module);
        $this->app->loadLang('index');

        $this->setReferer();

        $this->view->header->title     = $this->lang->user->deny;
        $this->view->module            = $module;
        $this->view->method            = $method;
        $this->view->denyPage          = $this->referer;
        $this->view->refererBeforeDeny = $refererBeforeDeny;

        die($this->display());
    }

    /**
     * The user control panel of the front
     * 
     * @access public
     * @return void
     */
    public function control()
    {
        if($this->app->user->account == 'guest') $this->locate(inlink('login'));
        $this->display();
    }

    /**
     * View current user's profile.
     * 
     * @access public
     * @return void
     */
    public function profile()
    {
        if($this->app->user->account == 'guest') $this->locate(inlink('login'));
        $user = $this->user->getByAccount($this->app->user->account);

        $this->view->user = $this->user->switchLevel($user);
        $this->display();
    }

    /**
     * List threads of one user.
     * 
     * @access public
     * @return void
     */
    public function thread($recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        if($this->app->user->account == 'guest') $this->locate(inlink('login'));
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $threads = $this->loadModel('thread')->getByUser($this->app->user->account, $pager);
        $this->view->threads = $threads;
        $this->view->pager   = $pager;
        $this->display();
    }

    /**
     * List replies of one user.
     * 
     * @access public
     * @return void
     */
    public function reply($recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        if($this->app->user->account == 'guest') $this->locate(inlink('login'));
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $replies = $this->loadModel('thread')->getReplyByUser($this->app->user->account, $pager);
        $this->view->replies = $replies;
        $this->view->pager   = $pager;
        $this->display();
    }

    /**
     * List message of a user.
     * 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function message($recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        if($this->app->user->account == 'guest') $this->locate(inlink('login'));

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        $this->view->messages = $this->loadModel('message')->getByAccount($this->app->user->account, $pager);
        $this->view->pager    = $pager;
        $this->display();
    }

    /**
     * Edit a user. 
     * 
     * @access public
     * @return void
     */
    public function edit()
    {
        if($this->app->user->account == 'guest') $this->locate(inlink('login'));
        if(!empty($_POST))
        {
            $this->user->update($this->app->user->account);
            if(dao::isError()) die(js::error(dao::getError()));
            die(js::locate(inlink('profile'), 'parent'));
        }
        $this->view->user = $this->user->getByAccount($this->app->user->account);
        $this->display();
    }

    /**
     * Delete a user.
     * 
     * @param mixed $userID 
     * @param string $confirm 
     * @access public
     * @return void
     */
    public function delete($userID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->user->confirmDelete, $this->createLink('user', 'delete', "userID=$userID&confirm=yes")));
        }
        else
        {
            $this->user->delete(TABLE_USER, $userID);
            die(js::locate($this->createLink('company', 'browse'), 'parent'));
        }
    }

    /**
     *  Forbid users
     *
     * @param string $date
     * @param int    $userID
     * @param int    $recTotal
     * @param int    $recPerPage
     * @param int    $pagerID
     * @access public
     * @return void
     */
    public function forbid($date = '0', $userID = 0, $recTotal = 0, $recPerPage = 10, $pageID = 1)
    {
        if ($date != '0') $this->user->forbid($date, $userID);

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $users = $this->user->getUsers($pager);

        if(!empty($_POST))
        {
            $userName = fixer::input('post')->get();
            $users = $this->user->getUsers($pager, $userName->userName);
        }
 
        $this->view->users    = $users;
        $this->view->pager    = $pager;
        $this->display();
    }

    /**
     * set the referer 
     * 
     * @param  string $referer 
     * @access private
     * @return void
     */
    private function setReferer($referer = '')
    {
        if(!empty($referer))
        {
            $this->referer = helper::safe64Decode($referer);
        }
        else
        {
            $this->referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        }
    }

    /**
     * get the forgotten password
     *
     * @access public
     * @return void
     */
    public function resetPassword()
    {
        if(!empty($_POST))
        {
            $user = $this->user->checkEmail($this->post->account, $this->post->email);
            if($user)
            {
                $account   = $this->post->account;
                $safeMail  = $user->email;
                $resetKey  = md5(str_shuffle(md5($account . mt_rand(0, 99999999) . microtime())) . microtime());
                $resetURL  = "http://". $_SERVER['HTTP_HOST'] . $this->inlink('checkresetkey', "key=$resetKey");
                $notice    = $this->lang->user->resetmail->notice;
                $this->user->resetKey($account, $resetKey);
                include('resetPassMail.php');
                $this->loadModel('mail')->send($account, $this->lang->user->resetmail->subject, $mailContent); 
                if($this->mail->isError()) 
                {
                    echo js::error($this->mail->getError());
                }
                else
                {
                    die(js::confirm($this->lang->user->resetPassword->success, $this->createLink('index', 'index'),'','parent'));
                }
            }
            else
            {
                echo die(js::error($this->lang->user->resetPassword->failed));
            }
        }
        $this->display();         
    }

    /**
     * check the resetKey and reset password 
     *
     * @access public
     * @return void
     */
    public function checkResetKey($resetKey)
    {
        if(!empty($_POST))
        {
            $this->user->resetPassword($this->post->resetKey, $this->post->password1); 
            echo js::alert($this->lang->user->reset->success); 
            die(js::locate('index.html'));
        }
        if(!$this->user->checkResetKey($resetKey))
        {
            die(js::error("error")); 
        }
        else
        {
            $this->view->resetKey = $resetKey;
            $this->display();
        }
    }

    public function changeSect($sect = null)
    {
        if($this->app->user->account == 'guest') $this->locate(inlink('login'));
        if($sect !== null)
        {
            $sect = (int)$sect;
            $this->dao->update(TABLE_USER)->set('sect')->eq($sect)->where('id')->eq($this->app->user->id)->exec(false);
            $this->app->user->sect = $sect;
            $this->session->set('user', $this->app->user);
            die(js::locate(inlink('profile'), 'parent'));
        }
        $this->display();
    }

    /**
     * OpenID login 
     * 
     * @param  string    $provider sina|qq|gmail|github 
     * @access public
     * @return void
     */
    public function openIDLogin($provider)
    {
        if($provider == 'sina')
        {
            $this->app->loadClass('sina', $static = true);
            $sina = new SaeTOAuthV2($this->config->user->openID->sina->akey , $this->config->user->openID->sina->skey);
            $url  = $sina->getAuthorizeURL($this->config->user->openID->sina->callbackUrl);
            $this->locate($url);
        }
    }

    /**
     * Callback of sina.
     * 
     * @access public
     * @return void
     */
    public function callback()
    {
        $this->app->loadClass('sina', $static = true);
        $sina = new SaeTOAuthV2($this->config->user->openID->sina->akey , $this->config->user->openID->sina->skey);

        $token = array();
        if(isset($_REQUEST['code'])) 
        {
            $keys         = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = $this->config->user->openID->sina->callbackUrl;
            try 
            {
                $token = $sina->getAccessToken('code', $keys);
            } 
            catch(OAuthException $e){}
        }

        if(!$token) die(js::error('授权失败'));

        $_SESSION['token'] = $token;
        setcookie( 'weibojs_'.$sina->client_id, http_build_query($token));

        $sina = new SaeTClientV2($this->config->user->openID->sina->akey , $this->config->user->openID->sina->skey, $_SESSION['token']['access_token'] ); //验证
        $user = $sina->show_user_by_id($token['uid']);
        if(!$this->checkOpenID('sina', $user['id']))
        {
            $this->view->user    = $user;
            $this->display();
        }
    }

    /**
     * Check openID if has been logined. 
     * 
     * @param  string $provider 
     * @param  int    $openID 
     * @access public
     * @return void
     */
    public function checkOpenID($provider, $openID)
    {
        $account = $this->dao->select('account')->from(TABLE_OPENID)
            ->where('provider')->eq($provider)
            ->andWhere('openID')->eq($openID)
            ->fetch('account', false);
        if(!$account) return false;
        $user = $this->user->getByAccount($account);
        $this->session->set('user', $user);
        $this->app->user = $this->session->user;
        die(js::locate($this->createLink('user', 'control'), 'parent'));
    }

    /**
     * Add account for openID.
     * 
     * @access public
     * @return void
     */
    public function addAccount()
    {
        if($_POST)
        {
            $user = fixer::input('post')
                ->setDefault('join', date('Y-m-d'))
                ->setDefault('last', helper::now())
                ->setDefault('visits', 1)
                ->setIF($this->cookie->r != '', 'referee', $this->cookie->r)
                ->setIF($this->cookie->r == '', 'referee', '')
                ->remove('openID')
                ->get();

            $this->dao->insert(TABLE_USER)->data($user)
                ->autoCheck()
                ->batchCheck('account,realname,email', 'notempty')
                ->check('account', 'unique', '1=1', false)
                ->check('account', 'account')
                ->checkIF($this->post->email != false, 'email', 'email')
                ->exec();

            if(dao::isError()) die(js::error(dao::getError()));

            $this->bind($user->account, $this->post->openID);
            die(js::locate($this->createLink('index', 'index'), 'parent'));
        }
    }

    /**
     * Bind openID and zentao user.
     * 
     * @param  string $account 
     * @param  int    $openID 
     * @access public
     * @return void
     */
    public function bind($account = '', $openID = 0)
    {
        $user = $account ? $this->user->getByAccount($account) : $this->user->identify($this->post->account, $this->post->password);
        if($this->post->openID) $openID = $this->post->openID;
        if($user)
        {
            /* Register the session. */
            $this->session->set('user', $user);
            $this->app->user = $this->session->user;

            $this->dao->insert(TABLE_OPENID)
                ->set('account')->eq($user->account)
                ->set('provider')->eq('sina')
                ->set('openID')->eq($openID)
                ->exec(false);
            die(js::locate($this->createLink('user', 'control'), 'parent'));
        }
        else
        {
            die(js::error($this->lang->user->loginFailed));
        }
    }
}
