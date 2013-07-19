<?php
/**
 * The html template file of index method of upgrade module of ZenTaoPMS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id$
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<table align='center' class='table table-bordered table-5'>
  <caption><?php echo $lang->upgrade->index;?></caption>
  <tr><td><?php printf($lang->upgrade->setOkFile, $okFile, $okFile, $okFile);?></td></tr>
</table>
<?php include '../../common/view/footer.lite.html.php';?>
