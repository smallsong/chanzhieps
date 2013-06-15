<?php
/**
 * The html template file of step4 method of install module of XiRangBPS.
 *
 * @copyright Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author	  Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package	  XiRangBPS
 * @version	  $Id: step4.html.php 867 2010-06-17 09:32:58Z wwccss $
 */
?>
<?php include './header.html.php';?>
<div class='container'>
  <table class='table' align='center'>
	<caption><?php echo $lang->install->success;?></caption>
    <tr>
      <td>
        <?php
        if(isset($adminConfig)) echo '<pre>' . $lang->install->saveAdmin . $adminConfig . '</pre>';
        echo '<p  class="a-center">';
        echo html::linkButton($lang->install->visitFront, 'index.php');
        echo html::linkButton($lang->install->visitAdmin, 'admin.php');
        echo '</p>';
        ?>
      </td>
	</tr>
  </table>
</div>
<?php include './footer.html.php';?>
