<?php
/**
 * The browse view file of company module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     company
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<form action='' method='post' id='ajaxForm'>
  <table class='table table-form'>
    <caption><?php echo $lang->company->setBasic;?></caption> 
    <tr>
      <th class='w-100px'><?php echo $lang->company->name;?></th> 
      <td><?php echo html::input('name', isset($this->config->company->name) ? $this->config->company->name : '', "class='text-1'");?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->company->desc;?></th> 
      <td><?php echo html::textarea('desc',  isset($this->config->company->desc) ? $this->config->company->desc : '', "class='area-1' rows='5'");?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->company->content;?></th> 
      <td><?php echo html::textarea('content',  isset($this->config->company->content) ? $this->config->company->content : '', "class='area-1' rows='15'");?></td> 
    </tr>
    <tr>
      <th></th>
      <td>
        <?php echo html::submitButton();?>
        <span id='responser'></span>
      </td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
