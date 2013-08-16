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
<form method='post' id='ajaxForm'>
  <table class='table table-form'>
    <caption><?php echo $lang->company->setContact;?></caption> 
    <tr>
      <th><?php echo $lang->company->phone;?></th> 
      <td><?php echo html::input('phone',  isset($contact->phone) ? $contact->phone : '', "class='text-3'");?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->company->fax;?></th> 
      <td><?php echo html::input('fax', isset($contact->fax) ? $contact->fax : '', "class='text-3'");?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->company->email;?></th> 
      <td><?php echo html::input('email', isset($contact->email) ? $contact->email : '', "class='text-3'");?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->company->qq;?></th> 
      <td><?php echo html::input('qq', isset($contact->qq) ? $contact->qq : '', "class='text-3'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->company->weixin;?></th> 
      <td><?php echo html::input('weixin', isset($contact->weixin) ? $contact->weixin : '', "class='text-3'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->company->weibo;?></th> 
      <td><?php echo html::input('weibo', isset($contact->weibo) ? $contact->weibo : '', "class='text-3'");?></td>
    </tr>
     <tr>
      <th><?php echo $lang->company->wangwang;?></th> 
      <td><?php echo html::input('wangwang', isset($contact->wangwang) ? $contact->wangwang : '', "class='text-3'");?></td>
    </tr>
    <tr>
      <th class='w-100px'><?php echo $lang->company->address?></th> 
      <td><?php echo html::input('address', isset($contact->address) ? $contact->address : '', "class='text-5'");?></td> 
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
