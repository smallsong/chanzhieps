<?php
/**
 * The browse view file of block module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     company
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<form method="post" id="ajaxForm" class="form-horizontal">
  <fieldset>
    <legend><?php echo $lang->company->setContact;?></legend>
    <div class="control-group">
      <label class="control-label" for="address"><?php echo $lang->company->address?></label>
      <div class="controls"><?php echo html::input('address', isset($contact->address) ? $contact->address : '', 'class="input-xxlarge"');?></div>
    </div>
    <div class="control-group">
      <label class="control-label" for="phone"><?php echo $lang->company->phone;?></label>
      <div class="controls"><?php echo html::input('phone',  isset($contact->phone) ? $contact->phone : '', '');?></div>
    </div>
    <div class="control-group">
      <label class="control-label" for="email"><?php echo $lang->company->email;?></label>
      <div class="controls"><?php echo html::input('email', isset($contact->email) ? $contact->email : '', '');?></div>
    </div>
    <div class="control-group">
      <label class="control-label" for="fax"><?php echo $lang->company->fax;?></label>
      <div class="controls"><?php echo html::input('fax', isset($contact->fax) ? $contact->fax : '', '');?></div>
    </div>
    <div class="control-group">
      <label class="control-label" for="qq"><?php echo $lang->company->qq;?></label>
      <div class="controls"><?php echo html::input('qq', isset($contact->qq) ? $contact->qq : '', '');?></div>
    </div>
    <div class="control-group">
      <label class="control-label" for="weixin"><?php echo $lang->company->weixin;?></label>
      <div class="controls"><?php echo html::input('weixin', isset($contact->weixin) ? $contact->weixin : '', '');?></div>
    </div>
    <div class="control-group">
      <label class="control-label" for="weibo"><?php echo $lang->company->weibo;?></label>
      <div class="controls"><?php echo html::input('weibo', isset($contact->weibo) ? $contact->weibo : '', '');?></div>
    </div>
     <div class="control-group">
      <label class="control-label" for="wangwang"><?php echo $lang->company->wangwang;?></label>
      <div class="controls"><?php echo html::input('wangwang', isset($contact->wangwang) ? $contact->wangwang : '', '');?></div>
    </div>
  </fieldset>
  <div class="form-actions">
    <?php echo html::submitButton('','btn btn-primary btn-large');?>
    <span id="responser"></span>
  </div>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
