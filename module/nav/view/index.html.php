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
  <table class="table table-bordered table-inline">
    <caption><?php echo $lang->setMenu;?></caption>
    <tr>
      <td>  
        <ul class="menuList ulGrade1">
          <?php 
          foreach($menus[1] as $menu)
          {
              echo '<li class="liGrade1">';
              echo $this->menu->createEntry(1, $menu);
              if(isset($menus[2][$menu['key']]))
              {
                  echo '<ul class="ulGrade2">';
                  foreach($menus[2][$menu['key']] as $menu2)
                  {
                      echo '<li class="liGrade2">';
                      echo $this->menu->createEntry(2, $menu2);
                      if(isset($menus[3][$menu2['key']]))
                      {
                          echo '<ul class="ulGrade3">';
                          foreach($menus[3][$menu2['key']] as $menu3)
                          {
                              echo  '<li class="liGrade3">'. $this->menu->createEntry(3, $menu3) .'</li>';
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
      </td>
    </tr>
  </table>
</form>

<?php /* hidden menuSource start .*/ ?>
<div id="grade1MenuSource" class="hide">
  <li class="liGrade1">
    <?php echo $this->menu->createEntry(1);?>
  </li>
</div>
<div id="grade2MenuSource" class="hide">
  <ul class="ulGrade2">
    <li class="liGrade2"><?php echo $this->menu->createEntry(2);?></li>
  </ul>
</div>
<div id="grade3MenuSource" class="hide">
  <ul class="ulGrade3">
    <li class="liGrade3"><?php echo $this->menu->createEntry(3);?></li>
  </ul>
</div>
<?php /* hidden menuSource end.*/ ?>

<?php include '../../common/view/footer.admin.html.php';?>
