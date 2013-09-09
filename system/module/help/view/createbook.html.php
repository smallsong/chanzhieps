<?php
/**
 * The create book view file of help of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Tingting Dai<daitingting@xirangit.com>
 * @package     help
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<form id='ajaxForm' method='post' enctype='multipart/form-data'>
  <table class='table table-form'>
    <caption><?php echo $lang->book->create;?></caption>
    <tr>
      <th class="w-100px"><?php echo $lang->book->name;?></th>
      <td><?php echo html::input('name', '', 'class=text-1');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->book->summary;?></th>
      <td><?php echo html::textarea('summary', '', "class='area-1' rows='4'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->book->code;?></th>
      <td><?php echo html::input('code', '', "class='text-1' autocomplete='off' placeholder='" . $lang->help->codealnum . "'");?></td>
    </tr>
    <tr><th></th><td><?php echo html::submitButton();?><span class='red f-12px' id='responser' style='display: none'></span></td></tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
