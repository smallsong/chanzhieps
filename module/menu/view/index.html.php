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
<?php include './menucode.html.php'; ?>
<form class="form-inline" id="menuForm" method="post">
<ul class="menuList grade1">
<?php 
foreach($menus[1] as $menu)
{
    echo '<li class="grade1">';
    echo $this->menu->inputTags(1, $menu);
    if(isset($menus[2][$menu['g1key']]))
    {
        echo '<ul class="grade2">';
        foreach($menus[2][$menu['g1key']] as $menu2)
        {
            echo '<li>';
            echo $this->menu->inputTags(2, $menu2);
            if(isset($menus[3][$menu2['g2key']]))
            {
                echo '<ul class="grade3">';
                foreach($menus[3][$menu2['g2key']] as $menu3)
                {
                    echo  '<li>'. $this->menu->inputTags(3, $menu3) .'</li>';
                }
                echo '</ul>';
            }
            echo '</li>';
        }
        echo '</ul>';
    }
    echo '</li>';
}
?>
  <li><?php echo html::a('javascript:;', $lang->save, '', 'class="btn btn-primary" onclick="return submitForm()"')?></li>
</ul>
</form>

<?php include '../../common/view/footer.admin.html.php';?>
