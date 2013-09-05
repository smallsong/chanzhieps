<?php
/**
 * The html template file of deny method of user module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     chanzhiEPS
 * @version     $Id: deny.html.php 824 2010-05-02 15:32:06Z wwccss $
 */
include '../../common/view/header.lite.html.php';
?>
<table class='table table-3'> 
  <caption><?php echo $app->user->account, ' ', $lang->user->deny;?></caption>
  <tr>
    <td>
      <?php
      $moduleName = isset($lang->$module->common)  ? $lang->$module->common:  $module;
      $methodName = isset($lang->$module->$method) ? $lang->$module->$method: $method;

      printf($lang->user->errorDeny, $moduleName, $methodName);
      echo "<br />";
      echo html::a($this->createLink($config->default->module), $lang->index->common);
      if($refererBeforeDeny) echo html::a(helper::safe64Decode($refererBeforeDeny), $lang->user->goback);
      echo html::a($this->createLink('user', 'logout', "referer=" . helper::safe64Encode($denyPage)), $lang->user->relogin);
      ?>
    </td>
  </tr>  
</table>
</body>
</html>
