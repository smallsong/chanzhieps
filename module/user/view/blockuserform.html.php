<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<div class='box-title'><?php $session->user->account == 'guest' ? print($lang->dashboard) : printf($lang->welcome, $session->user->account);?></div>
<div class="box-content" id='userform'>
  <?php 
  if($session->user->account != 'guest')
  {
      $controlLink = html::a($this->createLink('user', 'control'), $lang->dashboard);
      $logoutLink  = html::a($this->createLink('user', 'logout'), $lang->logout);
      echo $controlLink . ' ' . $logoutLink;
  }
  ?>
  <?php if($session->user->account == 'guest'):?>
  <?php
  if(empty($referer))
  {
     if(!$this->server->http_referer or 
         strpos($this->server->http_referer, $app->site->domain) == false or 
         strpos($this->server->http_referer, 'log') != false)
     {
         $referer = $config->webRoot;
     }    
     else
     {
         $referer = $this->server->http_referer;
     }
  }   
  ?>
  <form method='post' target='hiddenwin' action='<?php echo $this->createLink('user', 'login');?>' class='bd-none'>
    <table class='table-1' style='border:none'>
      <tr>
        <th class='w-100px'><nobr><?php echo $lang->account;?></nobr></th>
        <td><input type='text' name='account' class='w-100px' /></td>
      </tr>
      <tr>
        <th><?php echo $lang->password;?></th>
        <td><nobr><input type='password' name='password' class='w-100px' /></nobr></td>
      </tr>
      <tr>
        <td>
          <input type='hidden' value='<?php echo $referer;?>' name='referer' />
        </td>
        <td>
          <?php 
          echo html::submitButton($lang->login) . "<br />";
          echo html::a($this->createLink('user', 'register'), $lang->register, '', "class='red'") . '<br />';
          echo html::a($this->createLink('user', 'resetpassword'), $lang->forgotPassword, '');
          ?>
        </td>
      </tr>
      <?php if(strpos($this->app->siteCode, 'zentao') === false):?>
      <tr><td colspan='2'><i><?php echo $lang->user->lblZenTaoID;?></i></td></tr>
      <?php endif;?>

      <?php if(strpos($this->app->siteCode, 'zentao') !== false):?>
      <tr>
        <td colspan='2'>
        <i><?php echo $lang->user->login->openID;?></i>
        <?php 
          foreach($config->user->openID->List as $provider => $name) 
          {
              echo html::a(inlink('openIDLogin', "provider=$provider"), html::image("./theme/default/images/default/openid-$provider.gif"));
          }
        ?>
        </td>
      </tr>
      <?php endif;?>
    </table>
  </form>
  <?php endif;?>
</div>
