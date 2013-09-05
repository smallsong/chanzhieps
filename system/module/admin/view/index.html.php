<?php
/**
 * The index view file of admin module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiyingl@xirangit.com>
 * @package     admin
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='container' id='shortcutBox'>
  <div class='row'>
    <div class='col-md-4 col-sm-6'> 
      <div class="shortcut article-create">
        <?php echo html::a($this->createLink('article', 'create'), '<h3>' . $lang->admin->shortcuts->createArticle . '</h3>')?>
      </div>
    </div>
    <div class='col-md-4 col-sm-6'>
      <div class="shortcut article-admin">
        <?php echo html::a($this->createLink('product', 'create'), '<h3>' . $lang->admin->shortcuts->createProduct . '</h3>')?>
      </div>
    </div>
    <div class='col-md-4 col-sm-6'>
      <div class="shortcut category">
        <?php echo html::a($this->createLink('comment', 'admin'), '<h3>' . $lang->admin->shortcuts->comment . '</h3>')?>  
      </div>
    </div>
    <div class='col-md-4 col-sm-6'>
      <div class="shortcut site">
        <?php echo html::a($this->createLink('site', 'setBasic'), '<h3>' . $lang->admin->shortcuts->site . '</h3>')?>
      </div>
    </div>
    <div class='col-md-4 col-sm-6'>
      <div class="shortcut company">
        <?php echo html::a($this->createLink('company', 'setBasic'), '<h3>' . $lang->admin->shortcuts->company . '</h3>')?>
      </div>
    </div>
    <div class='col-md-4 col-sm-6'>
      <div class="shortcut contact">
        <?php echo html::a($this->createLink('company', 'setcontact'), '<h3>' . $lang->admin->shortcuts->contact . '</h3>')?>  
      </div>
    </div>      
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
