<?php
/**
 * The setbasic view file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      xiying Guang <guanxiying@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<form action='' method='post' id='ajaxForm'>
  <table class='table table-form'>
    <caption><?php echo $lang->site->setBasic;?></caption> 
    <tr>
      <th class='w-100px'><?php echo $lang->site->name;?></th> 
      <td><?php echo html::input('name', $this->config->site->name, "class='text-3'");?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->site->copyright;?></th> 
      <td><?php echo html::input('copyright', $this->config->site->copyright, "class='text-3'");?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->site->keywords;?></th> 
      <td><?php echo html::input('keywords', $this->config->site->keywords, "class='text-1'");?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->site->slogan;?></th> 
      <td><?php echo html::input('slogan', $this->config->site->slogan, "class='text-1'");?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->site->desc;?></th> 
      <td><?php echo html::textarea('desc', $this->config->site->desc, "class='area-1' rows='10'");?></td> 
    </tr>
   <tr>
      <th><?php echo $lang->site->icp;?></th> 
      <td><?php echo html::input('icp', $this->config->site->icp, "class='text-1'");?></td> 
    </tr>
    <tr>
      <th></th>
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
