<?php
/**
 * The html template file of select version method of upgrade module of ZenTaoPMS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id$
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<form method='post' action='<?php echo inlink('confirm');?>'>
  <table align='center' class='table table-bordered table-5'>
    <caption><?php echo $lang->upgrade->selectVersion;?></caption>
    <tr>
      <td>
        <p>
        <?php 
        echo html::select('fromVersion', $lang->upgrade->fromVersions, $version);
        echo "<span class='red'>{$lang->upgrade->versionNote}</span>";
        ?>
        </p>
        <?php echo html::submitButton($lang->upgrade->common);?>
      </td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.lite.html.php';?>
