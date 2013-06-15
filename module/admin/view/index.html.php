<?php
/**
 * The index view file of admin module of XiRangEPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/colorbox.html.php';?>
<div class='row mt-10px'>
  <div class='u-1'>
    <table class='table-4' align='center'>
      <caption><?php echo $lang->admin->selectSite;?></caption>
      <tr>
        <td>
          <?php
          foreach($sites as $siteID => $siteName)
          {
              echo "<p><span class='f-16px strong'>" . html::a(inlink('site', "id=$siteID"), $siteName) . '</span>(';
              echo html::a($this->createLink('site', 'edit', "id=$siteID"), $lang->edit, '', 'class="colorbox"');
              if($app->user->isSuper) echo html::a($this->createLink('site', 'delete', "id=$siteID"), $lang->delete, 'hiddenwin');
              echo ')</p>';
          }
          ?>
        </td>
        <td class='a-center'>
          <?php 
          echo '<p>' . html::a($this->createLink('site', 'create'), $lang->admin->addSite, '', "class='colorbox f-16px strong'") . '</p>';
          echo '<p>' . html::a($this->createLink('admin', 'navigate'), $lang->admin->navigate, '', "class='f-16px strong'") . '</p>';
          ?>
        </td>
      </tr>
    </table>
    <div class='a-center f-16px'><?php echo html::a($this->createLink('user', 'logout'), $lang->logout);?></div>   
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
