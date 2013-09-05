<?php
/**
 * The edit view of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='row-1'>
  <form method='post' target='hiddenwin' class='u-1 cont'>
    <table align='center' class='table-1'> 
      <caption><?php echo $lang->site->create;?></caption>
      <tr>
        <th class='rowhead'><?php echo $lang->site->name;?></th>
        <td><?php echo html::input('name', '', "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->site->code;?></th>
        <td><?php echo html::input('code', '', "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->site->domain;?></th>
        <td><?php echo html::input('domain', '', "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->site->logo;?></th>
        <td><?php echo html::input('logo', '', "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->site->slogan;?></th>
        <td><?php echo html::input('slogan', '', "class='text-1'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->site->mission;?></th>
        <td><?php echo html::textarea('mission', '', "rows=5 class='text-1'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->site->keywords;?></th>
        <td><?php echo html::textarea('keywords', '', "rows=5 class='text-1'");?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->site->type;?></th>
        <td><?php echo html::radio('type', $lang->site->types, 'portal');?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->site->theme;?></th>
        <td><?php echo html::radio('theme', $lang->site->themes, 'default');?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->site->linkSites;?></th>
        <td><?php echo html::checkbox('linkSites', $sites);?></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->site->admins;?></th>
        <td><?php echo html::input('admins', '', "class='text-1'");?></td>
      </tr>  
      <tr><td colspan='2' class='a-center'><?php echo html::submitButton();?></td></tr>
    </table>
  </form>
</div>  
<?php include '../../common/view/footer.admin.html.php';?>
