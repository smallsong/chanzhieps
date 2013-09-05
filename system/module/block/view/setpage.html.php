<?php
/**
 * The setpage view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class="yui-d0">
  <form method='post' target='hiddenwin'>
  <table align='center' class='table-1'>
    <caption><?php echo $lang->block->setPage;?></caption>
    <?php foreach($lang->block->regions as $region => $regionName):?>
    <tr>
      <td><?php echo $regionName;?></td>
      <td>
        <?php 
        if(isset($layouts[$region]))
        {
            $blocks = explode(',', $layouts[$region]);
            foreach($blocks as $block)
            {
                echo html::select("region{$region}[]", $allBlocks, $block);
            }
        }

        echo html::select("region{$region}[]", $allBlocks, '');
        ?>
      </td>
    </tr>
    <?php endforeach;?>
    <tr>
      <td colspan='2' class='a-center'><?php echo html::submitButton();?></td>
    </tr>
  </table>
  </form>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
