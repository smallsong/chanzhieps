<?php
/**
 * The control file of user module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
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
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $user = $this->user->identify($this->post->account, $this->post->password1);
            if($user)
            {
                $this->session->set('user', $user);
                $this->app->user = $this->session->user;
                $url = $this->post->referer ? urldecode($this->post->referer) : inlink('user', 'control');
                $this->send( array('result' => 'success', 'locate'=>$url) );
            }
        }

        /* Set the referer. */
        if(!isset($_SERVER['HTTP_REFERER']) or strpos($_SERVER['HTTP_REFERER'], 'login.php') != false)
        {
            $referer = urlencode($this->config->webRoot);
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
            if($this->referer and strpos($loginLink . $denyLink . $regLink, $this->referer) !== false)
            {
                $locate = $this->referer;
            }
            else
            {
                $locate = $this->createLink($this->config->default->module);
            }

            $this->locate($locate);
        }

        /* If the user sumbit post, check the user and then authorize him. */
        if(!empty($_POST))
        {
            $user = $this->user->identify($this->post->account, $this->post->password);
            if($user)
            {
                /* Authorize the user. */
                $user->rights = $this->user->authorize($user);

                /* Register the session. */
                $this->session->set('user', $user);
                $this->app->user = $this->session->user;

                /* Goto the referer or to the default module */
                if($this->post->referer != false and strpos($loginLink . $denyLink . $regLink, $this->post->referer) === false)
                {
                    $this->send(array('result'=>'success', 'locate'=> urldecode($_POST['referer'])));
                }
                else
                {
                    $default = $this->config->user->default;
                    $this->send(array('result'=>'success', 'locate' => $this->createLink($default->module, $default->method)));
                }
            }
            else
            {
                $this->send(array('result'=>'fail', 'message' => $this->lang->user->loginFailed));
            }
        }

        $this->view->title   = $this->lang->user->login->common;
        $this->view->referer = $this->referer;

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

        $this->view->title             = $this->lang->user->deny;
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
        $this->view->user = $this->user->getByAccount($this->app->user->account);
        $this->display();
    }

    /**
     * List threads of one user.
     * 
     * @access public
     * @return void
     */
    public function thread($recTotal = 0, $recPerPage = 10, $pageID = 1)
    {
        if($this->app->user->account == 'guest') $this->locate(inlink('login'));

        /* Load the pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        /* Load the forum lang to change the pager lang items. */
        $this->app->loadLang('forum');

        $this->view->threads = $this->loadModel('thread')->getByUser($this->app->user->account, $pager);
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

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        /* Load the thread lang thus to rewrite the page lang items. */
        $this->app->loadLang('thread');    

        $this->view->replies = $this->loadModel('reply')->getByUser($this->app->user->account, $pager);
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
            if(dao::isError()) $this->send( array( 'result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'locate' => inlink('profile')));
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
     *  Admin users list.
     *
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pagerID
     * @access public
     * @return void
     */
    public function admin($recTotal = 0, $recPerPage = 10, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $key = $this->post->key ? $this->post->key : '';

        $this->view->users = $this->user->getList($pager, $key);
        $this->view->key   = $key;
        $this->view->pager = $pager;

        $this->display();
    }

    /**
     * forbid a user.
     *
     * @param string $date
     * @param int    $userID
     * @return viod
     */
    public function forbid($userID, $date)
    {
        if(!$userID or !isset($this->lang->user->forbidDate[$date])) $this->send(array('message' => $this->lang->user->forbidFail));       

        $result = $this->user->forbid($userID, $date);
        if($result)
        {
            $this->send(array('result'=>'success', 'message' => $this->lang->user->forbidSuccess));
        }
        else
        {
            $this->send(array('message' => dao::getError()));
        }
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
     * Change password.
     *
     * @access public
     * @return void
     */
    public function changePassword()
    {
        if($this->app->user->account == 'guest') $this->locate(inlink('login'));

        if(!empty($_POST))
        {
            $this->user->updatePassword($this->app->user->account);
            if(dao::isError()) $this->send(array( 'result' => 'fail', 'message' => dao::getError() ) );
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }

        $this->view->user = $this->user->getByAccount($this->app->user->account);
        $this->display();
    }

    /**
     * Reset password.
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
}
