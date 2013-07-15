<?php
/**
 * The model file of user module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php
class userModel extends model
{
    /**
     * Get the user list of an site.
     * 
     * @access public
     * @return array     the users.
     */
    public function getList()
    {
        return $this->dao->select('*')->from(TABLE_USER)->orderBy('account')->fetchAll();
    }

    /**
     * Get the basic info of some user.
     * 
     * @param mixed $users 
     * @access public
     * @return void
     */
    public function getBasicInfo($users)
    {
        $users = $this->dao->select('account, realname, `addedDate`, last, visits')->from(TABLE_USER)->where('account')->in($users)->fetchAll('account', false);
        if(!$users) return array();
        foreach($users as $account => $user) if($user->realname == '') $user->realname = $account;
        return $users;
    }

    /**
     * Get user by his account.
     * 
     * @param mixed $account   
     * @access public
     * @return object           the user.
     */
    public function getByAccount($account)
    {
        return $this->dao->select('*')->from(TABLE_USER)->where('account')->eq($account)->fetch('', false);
    }

    /**
     * Create a user.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $this->checkPassword();

        $user = fixer::input('post')
            ->setDefault('addedDate', date('Y-m-d H:i:s'))
            ->setDefault('last', helper::now())
            ->setDefault('visits', 1)
            ->setIF($this->post->password1 == false, 'password', '')
            ->setIF($this->cookie->r != '', 'referer', $this->cookie->r)
            ->setIF($this->cookie->r == '', 'referer', '')
            ->remove('password1, password2')
            ->get();
        $user->password = $this->createPassword($this->post->password1, $user->account, $user->addedDate); 

        $this->dao->insert(TABLE_USER)->data($user)
            ->autoCheck()
            ->batchCheck($this->config->user->register->requiredFields, 'notempty')
            ->check('account', 'unique', '1=1', false)
            ->check('account', 'account')
            ->checkIF($this->post->email != false, 'email', 'email')
            ->exec();
    }

    /**
     * Update an account.
     * 
     * @param mixed $account 
     * @access public
     * @return void
     */
    public function update($account)
    {
        if($_POST['password1'] != '') $this->checkPassword();
        if(dao::isError()) return false;
        $user = fixer::input('post')
            ->setIF(isset($_POST['addedDate']) and $this->post->addedDate == '', 'addedDate', '0000-00-00')
            ->setIF($this->post->password1 != false, 'password', md5($this->post->password1))
            ->cleanInt('imobile,qq,zipcode')
            ->specialChars('company,address,phone,')
            ->remove('password1, password2')
            ->get();
        $addedDate = $this->dao->select('*')
            ->from(TABLE_USER)
            ->where('account')->eq($account)
            ->fetch('addedDate');
        $user->password = $this->createPassword($this->post->password1, $account, $addedDate); 
        return $this->dao->update(TABLE_USER)->data($user)
            ->autoCheck()
            ->batchCheck($this->config->user->edit->requiredFields, 'notempty')
            ->checkIF($this->post->email != false, 'email', 'email')
            ->checkIF($this->post->msn != false, 'msn', 'email')
            ->checkIF($this->post->gtalk != false, 'gtalk', 'email')
            ->where('account')->eq($account)
            ->exec(false);
    }

    /**
     * Check the password is valid or not.
     * 
     * @access public
     * @return bool
     */
    public function checkPassword()
    {
        if($this->post->password1 != false)
        {
            if($this->post->password1 != $this->post->password2) dao::$errors['password1'][] = $this->lang->error->passwordsame;
            if(!validater::checkReg($this->post->password1, '|(.){6,}|')) dao::$errors['password1'][] = $this->lang->error->passwordrule;
        }
        else
        {
            dao::$errors['password1'][] = $this->lang->user->inputPassword;
        }
        return !dao::isError();
    }
    
    /**
     * Identify a user.
     * 
     * @param   string $account     the account
     * @param   string $password    the password
     * @access  public
     * @return  object              if is valid user, return the user object.
     */
    public function identify($account, $password)
    {
        if(!$account or !$password) return false;

        /* First get the user from database by account or email. */
        $user = $this->dao->select('*')->from(TABLE_USER)
            ->beginIF(validater::checkEmail($account))->where('email')->eq($account)->fi()
            ->beginIF(!validater::checkEmail($account))->where('account')->eq($account)->fi()
            ->fetch();

        /* Then check the password hash. */
        if(!$user) return false;
        if($this->createPassword($password, $user->account, $user->addedDate) != $user->password) return false;

        /* Update user data. */
        $user->ip = $this->server->remote_addr;
        $user->last = helper::now();
        $user->visits ++;
        $this->dao->update(TABLE_USER)->data($user)->where('account')->eq($account)->exec();

        /* Return him.*/
        return $user;
    }

    /**
     * Authorize a user.
     * 
     * @param   string $account   the account
     * @access  public
     * @return  array             the priviledges.
     */
    public function authorize($account)
    {
        $account = filter_var($account, FILTER_SANITIZE_STRING);
        if(!$account) return false;

        $rights = array();
        if($account == 'guest')
        {
            $sql = $this->dao->select('module, method')->from(TABLE_GROUP)->alias('t1')->leftJoin(TABLE_GROUPPRIV)->alias('t2')
                ->on('t1.id = t2.group')->where('t1.name')->eq('guest');
        }
        else
        {
            $sql = $this->dao->select('module, method')->from(TABLE_USERGROUP)->alias('t1')->leftJoin(TABLE_GROUPPRIV)->alias('t2')
                ->on('t1.group = t2.group')
                ->where('t1.account')->eq($account);
        }
        $stmt = $sql->query();
        if(!$stmt) return $rights;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $rights[strtolower($row['module'])][strtolower($row['method'])] = true;
        }
        return $rights;
    }

    /**
     * Juage a user is logon or not.
     * 
     * @access public
     * @return bool
     */
    public function isLogon()
    {
        return (isset($_SESSION['user']) and !empty($_SESSION['user']) and $_SESSION['user']->account != 'guest');
    }

    /**
     * Get users List 
     *
     * @param object  $pager
     * @param string  $userName
     * @access public
     * @return object 
     */
    public function getUsers($pager, $userName = '')
    {
        return $this->dao->select('*')->from(TABLE_USER)
            ->beginIF($userName != '')->where('account')->like("%$userName%")->fi()
            ->orderBy('id_asc')->page($pager)->fetchAll();
    }

    /**
     * Forbid the user
     *
     * @param string $date
     * @param int $userID
     * @access public
     * @return void
     */
    public function forbid($date, $userID)
    {
        switch($date)
        {
            case "oneday"   : $intdate = strtotime("+1 day");break;
            case "twodays"  : $intdate = strtotime("+2 day");break;
            case "threedays": $intdate = strtotime("+3 day");break;
            case "oneweek"  : $intdate = strtotime("+1 week");break;
            case "onemonth" : $intdate = strtotime("+1 month");break;
            case "forever"  : $intdate = strtotime("+10 years");break;
        }
        $format = 'Y-m-d H:i:s';

        $date = date($format,$intdate);
        $this->dao->update(TABLE_USER)->set('allowTime')->eq($date)->where('id')->eq($userID)->exec();
        if(dao::isError()) return dao::getError();
        return true;
    }

    /**
     * Identify email to regain the forgotten password 
     *
     * @access  public
     * @param   string account
     * @param   string email
     * @return  object              if is valid user, return the user object.
     */
    public function checkEmail($account, $email)
    {
        if(!$account or !$email) return false;

        if(RUN_MODE == 'admin' and strpos($this->config->admin->users, ",$account,") === false) return false;

        $user = $this->dao->select('*')->from(TABLE_USER)
            ->where('account')->eq($account)
            ->andWhere('email')->eq($email)
            ->fetch('', false);
        return $user;
    } 

    /**
     * update the resetKey.
     * 
     * @param  string   $resetKey 
     * @param  time     $resetedTime 
     * @access public
     * @return void
     */
    public function resetKey($account, $resetKey)
    {
        $this->dao->update(TABLE_USER)->set('resetKey')->eq($resetKey)->set('resetedTime')->eq(helper::now())->where('account')->eq($account)->exec(false);
    }

    /**
     * Check the resetKey.
     * 
     * @param  string   $resetKey 
     * @param  time     $resetedTime 
     * @access public
     * @return void
     */
    public function checkResetKey($resetKey)
    {
        $user = $this->dao->select('*')->from(TABLE_USER)
            ->where('resetKey')->eq($resetKey)
            ->fetch('');
        return $user;
    }

    /**
     * Reset the forgotten password.
     * 
     * @param  string   $resetKey 
     * @param  time     $resetedTime 
     * @access public
     * @return void
     */
    public function resetPassword($resetKey, $password)
    {
        $user = $this->dao->select('*')->from(TABLE_USER)
                ->where('resetKey')->eq($resetKey)
                ->fetch();
        
        $this->dao->update(TABLE_USER)
            ->set('password')->eq(md5($password))
            ->set('resetKey')->eq('')
            ->set('resetedTime')->eq('')
            ->where('resetKey')->eq($resetKey)
            ->exec();
    }

    /**
     * Create a strong password hash with md5.
     * 
     * @param  string    $password 
     * @param  string    $account 
     * @param  string    $addedTime 
     * @access public
     * @return string
     */
    public function createPassword($password, $account, $addedDate)
    {
        return md5(md5($password) . $account . $addedDate);
    }
}
