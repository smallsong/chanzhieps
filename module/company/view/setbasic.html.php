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
<?php include '../../common/view/kindeditor.html.php';?>
<form action="" method="post" id="ajaxForm" class="form-horizontal">
  <fieldset>
    <legend><?php echo $lang->company->setBasic;?></legend>
    <div class="control-group">
      <label class="control-label" for="name"><?php echo $lang->company->name;?></label>
      <div class="controls">
        <?php echo html::input('name', isset($this->config->company->name) ? $this->config->company->name : "", 'class="span4"');?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="desc"><?php echo $lang->company->desc;?></label>
      <div class="controls"><?php echo html::textarea('desc',  isset($this->config->company->desc) ? $this->config->company->desc : "", 'class="span10" rows="5"');?></div>
    </div>
    <div class="control-group">
      <label class="control-label" for="content"><?php echo $lang->company->content;?></label>
      <div class="controls"><?php echo html::textarea('content',  isset($this->config->company->content) ? $this->config->company->content : "", 'class="span10" rows="15"');?></div>
    </div>
  </fieldset>
  <div class="form-actions">
    <?php echo html::submitButton('','btn btn-primary btn-large');?>
    <span id="responser"></span>
  </div>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
