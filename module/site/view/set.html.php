<?php
/**
 * The edit view of site module of XiRangEPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='row'>
  <form method='post' target='hiddenwin' class='u-1 cont'>
    <table align='center' class='table-1'> 
      <caption><?php echo $lang->site->set;?></caption>
      <tr>
        <th class='a-center'><?php echo $lang->site->indexModules;?></th>
        <td><?php echo html::select('modules', $optionMenu, '', 'class=select-3 size=10 multiple');?></td>
        <td class='a-center'>
          <?php
          echo html::commonButton($lang->site->addModule,    "onclick=\"addItem('modules', 'indexModules')\"") . '<br />';
          echo html::commonButton($lang->site->deleteModule, "onclick=delItem('indexModules')");
          ?>
        </td>
        <td><?php echo html::select('indexModules[]', $indexModules, '', 'class=select-3 size=10 multiple');?></td>
        <td class='a-center'>
          <?php
          echo html::commonButton($lang->site->upModule,   "onclick=upItem('indexModules')") . '<br />';
          echo html::commonButton($lang->site->downModule, "onclick=downItem('indexModules')");
          ?>
        </td>
      </tr>  
      <tr>
        <th class='a-center'><?php echo $lang->site->menus;?></th>
        <td colspan='4'>
        <?php
        $optionMenu[0] = '';
        $menus = explode(',', $site->menus);
        foreach($menus as $menu)
        {
            echo html::select('menuModules[]', $optionMenu, is_numeric($menu) ? $menu : '');
            echo html::input('menuLinks[]', strpos($menu, '|') ? $menu : '', 'class=text-5');
            echo "<br />";
        }
        for($i = 0; $i < 5; $i ++)
        {
            echo html::select('menuModules[]', $optionMenu);
            echo html::input('menuLinks[]', '', 'class=text-5');
            echo "<br />";
        }
        ?>
        </td>
      </tr>  
      <tr><td colspan='5' class='a-center'><?php echo html::submitButton('', 'onclick=selectItem("indexModules")');?></td></tr>
    </table>
  </form>
</div>  
<?php include '../../common/view/footer.admin.html.php';?>
