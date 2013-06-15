<?php
/**
 * The index view file of guider module of XiRangBPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     pmguide
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../../../common/ext/pmguide/view/header.html.php';?>
<div class='row'>
  <div class='u-24-19'>
    <div class='cont'>
    <?php foreach($modules[0] as $parentModule):?>
    <?php $sonModules = isset($modules[$parentModule->id]) ? $modules[$parentModule->id] : array();?>
      <div class='box-title'>
        <div class='half-left'><?php echo '> ' . $parentModule->fullName;?></div>
        <div class='half-right'><?php echo html::a($this->createLink('guide', 'browse', "module=$parentModule->id"), $lang->more . $lang->arrow);?></div>
      </div>
      <div class='box-content'>
      <?php foreach($sonModules as $sonModule):?>
      <?php $browseLink = $this->createLink('guide', 'browse', "module=$sonModule->id");?>
        <table class='table-1 bd-none'>
          <tr>
            <td class='w-30px'><?php echo html::a($browseLink, $sonModule->fullName);?></td>
            <td>
              <?php 
              $moduleGuides = isset($stickyGuides[$sonModule->id]) ? $stickyGuides[$sonModule->id] : array();
              foreach($moduleGuides as $guide) echo html::a($this->createLink('guide', 'go', "id=$guide->id"), $guide->name, '_blank', "title=$guide->url");
              ?>
            </td>
            <td class='w-40px a-right'><?php echo html::a($browseLink, $lang->more . $lang->arrow);?></td>
          </tr>
        </table>
        <?php endforeach;?>
      </div>
    <?php endforeach;?>
    </div>
  </div>
  <div class='u-24-5'>
    <div class='cont pl-10px'>
      <div class='box-title'><?php echo $lang->guide->latest?></div>
      <div class='box-content'>
        <?php
        foreach($latestGuides as $guide) echo "<span>" . html::a($this->createLink('guide', 'go', "id=$guide->id"), $guide->name, '_blank', "title=$guide->url") . "</span>";
        ?>
      </div>
    </div>
  </div>
</div>
<?php include '../../../../common/ext/pmguide/view/footer.html.php';?>
<script>
$(function()
{
    $("tbody:odd").css('background', '#F7FFF0');
    $(".u-24-5 span:odd").css('background', '#FFF0F0');
})
</script>
