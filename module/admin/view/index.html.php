<?php
/**
 * The index view file of admin module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Xiying Guan <guanxiyingl@xirangit.com>
 * @package     admin
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='container' id='shortcutContainer'>
  <div class='row-fluid'>
    <div class='span4 shortcut article-create'> 
      <?php echo html::a($this->createLink('article', 'create'), '<h3>' . $lang->admin->shortcuts->createArticle . '</h3>')?>
    </div>
    <div class='span4 shortcut article-admin'> 
      <?php echo html::a($this->createLink('article', 'admin'), '<h3>' . $lang->admin->shortcuts->adminArticle . '</h3>')?>
    </div>
    <div class='span4 shortcut category'> 
      <?php echo html::a($this->createLink('tree', 'browse'), '<h3>' . $lang->admin->shortcuts->category . '</h3>')?>
    </div>
    <div class='row-fluid'>
      <div class='span3 shortcut site'> 
        <?php echo html::a($this->createLink('site', 'setBasic'), '<h3>' . $lang->admin->shortcuts->site . '</h3>')?>
      </div>
      <div class='span3 shortcut logo'> 
        <?php echo html::a($this->createLink('site', 'setlogo'), '<h3>' . $lang->admin->shortcuts->logo . '</h3>')?>
      </div>
     <div class='span3 shortcut company'>
        <?php echo html::a($this->createLink('company', 'setBasic'), '<h3>' . $lang->admin->shortcuts->company . '</h3>')?>
      </div>
      <div class='span3 shortcut contact'> 
        <?php echo html::a($this->createLink('company', 'setcontact'), '<h3>' . $lang->admin->shortcuts->contact . '</h3>')?>
      </div>      
    </div>

  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
