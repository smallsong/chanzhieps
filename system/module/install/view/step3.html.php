<?php
/**
 * The html template file of step3 method of install module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author	  Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package	 chanzhiEPS
 * @version	 $Id: step3.html.php 824 2010-05-02 15:32:06Z wwccss $
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class='container'>
  <?php if(isset($error)):?>
  <table class='table table-bordered' align='center'>
	<caption><?php echo $lang->install->error;?></caption>
    <tr><td class='red'><?php echo $error;?></td></tr>
    <tr><td><?php echo html::backButton($lang->install->pre, 'btn btn-primary');?></td></tr>
  </table>
  <?php else:?>
  <table class='table table-bordered'>
	<caption><?php echo $lang->install->saveConfig;?></caption>
    <tr>
      <td>
        <?php 
        echo html::textArea('config', $result->content, "rows='10' class='area-1 f-12px'");
        printf($lang->install->save2File, $result->myPHP);
        ?>
      </td>
    </tr>
    <tr><td class='a-center'><?php echo html::a(inlink('step4'), $lang->install->next, '', 'class="btn btn-primary"');?></td></tr>
  </table>
  <?php endif;?>
</div>
<?php include './footer.html.php';?>
