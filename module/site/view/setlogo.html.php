<?php
/**
 * The browse view file of block module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<form method="post" id="ajaxForm" enctype="multipart/form-data" class="form-horizontal">
  <fieldset>
    <legend><?php echo $lang->site->setLogo;?></legend>
    <div class="control-group">
      <div class="controls">
        <?php if(isset($this->config->site->logo)) echo html::image($logo->webPath, "width='150px'");?>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="files">&nbsp;</label>
      <div class="controls"><?php echo html::file('files');?></div>
    </div>
  </fieldset>
  <div class="form-actions">
    <?php echo html::submitButton('','btn btn-primary btn-large');?>
    <span id="responser"></span>
  </div>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
