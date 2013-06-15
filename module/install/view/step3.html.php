<?php
/**
 * The html template file of step3 method of install module of XiRangEPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author	  Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package	 XiRangEPS
 * @version	 $Id: step3.html.php 824 2010-05-02 15:32:06Z wwccss $
 */
?>
<?php include './header.html.php';?>
<?php
if(!isset($error))
{
    $configContent = <<<EOT
<?php
\$config->installed       = true;	
\$config->debug           = false;	
\$config->requestType     = '$requestType';	
\$config->db->host        = '$dbHost';	
\$config->db->port        = '$dbPort';	
\$config->db->name        = '$dbName';	
\$config->db->user        = '$dbUser';	
\$config->db->password    = '$dbPassword';		
\$config->db->prefix      = '$dbPrefix';	
\$config->webRoot         = '{$this->post->webRoot}';		
\$config->default->domain = '$domain';	
\$config->admin           = new stdclass();
\$config->admin->domain   = '$domain';
EOT;
}
?>
<div class='container'>
  <?php if(isset($error)):?>
  <table class='table table-bordered' align='center'>
	<caption><?php echo $lang->install->error;?></caption>
    <tr><td class="text-error"><?php echo $error;?></td></tr>
    <tr><td><?php echo html::commonButton($lang->install->pre, " onclick='javascript:history.back(-1)'");?></td></tr>
  </table>
  <?php else:?>
  <table class='table table-bordered' align='center'>
	<caption><?php echo $lang->install->saveConfig;?></caption>
	<tr>
	  <td class='a-center'><?php echo html::textArea('config', $configContent, "style='width:98%;' rows='15'  class='area-1 f-12px'");?></td>
	</tr>
    <tr>
      <td>
      <p>
      <?php
      $configRoot   = $this->app->getConfigRoot();
      $myConfigFile = $configRoot . 'my.php';
      if(is_writable($configRoot))
      {
          if(@file_put_contents($myConfigFile, $configContent))
          {
              printf($lang->install->saved2File, $myConfigFile);
          }
          else
          {
              printf($lang->install->save2File, $this->app->getConfigRoot() . 'my.php');
          }
      }
      else
      {
          printf($lang->install->save2File, $this->app->getConfigRoot() . 'my.php');
      }
      echo "</p>";
      echo "<div class='a-center'>" . html::a($this->createLink('install', 'step4'), $lang->install->next, '', 'class="btn btn-primary"') . '</div>';
      ?>
      </td>
	</tr>
  </table>
  <?php endif;?>
</div>
<?php include './footer.html.php';?>
