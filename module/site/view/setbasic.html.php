<?php
/**
 * The browse view file of block module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<form action="" method="post" id="ajaxForm" class="form-horizontal">
  <fieldset>
    <legend><?php echo $lang->site->setBasic;?></legend>
    <div class="control-group">
      <label class="control-label" for="name"><?php echo $lang->site->name;?></label>
      <div class="controls">
        <?php echo html::input('name', $this->config->site->name, '');?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="slogan"><?php echo $lang->site->slogan;?></label>
      <div class="controls"><?php echo html::input('slogan', $this->config->site->slogan, 'class="span10"');?></div>
    </div>
    <div class="control-group">
      <label class="control-label" for="desc"><?php echo $lang->site->desc;?></label>
      <div class="controls"><?php echo html::textarea('desc', $this->config->site->desc, 'class="span10" rows="5"');?></div>
    </div>
    <div class="control-group">
      <label class="control-label" for="copyrightStart"><?php echo $lang->site->copyrightStart;?></label>
      <div class="controls"><?php echo html::input('copyrightStart', $this->config->site->copyrightStart, 'class=""');?></div>
    </div>
    <div class="control-group">
      <label class="control-label" for="icp"><?php echo $lang->site->icp;?></label>
      <div class="controls"><?php echo html::input('icp', $this->config->site->icp, 'class=""');?></div>
    </div>
  </fieldset>
  <div class="form-actions">
    <?php echo html::submitButton('','btn btn-primary btn-large');?>
    <span id="responser"></span>
  </div>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
