<?php
/**
 * The side common view file of blog module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php
$treeMenu = $this->tree->getTreeMenu('blog', 0, array('treeModel', 'createBlogBrowseLink'));
?>
<div class='col-md-3'>
  <div class='box widget radius'> 
    <h4 class='title'><?php echo $lang->categoryMenu;?></h4>
    <?php echo $treeMenu;?>
  </div>
</div>
