<?php
/**
 * The browse view file of menu module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     menu
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include './menucode.html.php';?>
<form class="form-inline" id="menuForm" method="post">
<ul class="menuList grade1">
  <li>
     <?php echo html::select('menutypes', $lang->menu->types);?>
     <?php echo html::input('menu[1][title][]', '首页', 'class="input-small"');?> 
     <?php echo html::input('menu[1][url][]', 'http://www.baidu.com', 'class="input"');?> 
     <?php echo html::hidden('menu[1][g1key][]', '', 'class="input grade1key"');?> 
     <?php echo html::a('javascript:;', 'up', '', 'class="up"' ) ?>
     <?php echo html::a('javascript:;', 'down', '', 'class="down"') ?>
     <?php echo html::a('javascript:;', '添加', '', 'class="plus1"' ) ?>
     <?php echo html::a('javascript:;', '添加子类', '', 'class="plus2"' ) ?>
     <?php echo html::a('javascript:;', '删除导航', '', 'class="remove"' ) ?>
     <?php echo html::a('javascript:;', '展开子类', '', 'class="open"' ) ?>
     <?php echo html::a('javascript:;', '收起子类', '', 'class="shut"' ) ?>
  </li>
 <li><?php echo html::a('javascript:;', '保存', '', 'class="btn btn-primary" onclick="return submitForm()"')?></li>
</ul>
</form>

<?php include '../../common/view/footer.admin.html.php';?>
