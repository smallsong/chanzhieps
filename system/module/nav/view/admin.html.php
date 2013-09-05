<?php
/**
 * The browse view file of nav module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     nav
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include './navcode.html.php';?>
<?php js::set('cannotRemoveAll', $lang->nav->cannotRemoveAll); ?>
<form class='form-inline' id='navForm' method='post'>
  <table class='table table-inline'>
    <caption><?php echo $lang->nav->setNav;?></caption>
    <tr>
      <td>  
        <ul class='navList ulGrade1'>
          <?php 
          foreach($navs as $nav)
          {
              echo "<li class='liGrade1'>";
              echo $this->nav->createEntry(1, $nav);
              if(isset($nav->children))
              {
                  echo "<ul class='ulGrade2'>";
                  foreach($nav->children as $nav2)
                  {
                      echo "<li class='liGrade2'>";
                      echo $this->nav->createEntry(2, $nav2);
                      if(isset($nav2->children))
                      {
                          echo "<ul class='ulGrade3'>";
                          foreach($nav2->children as $nav3)
                          {
                              echo  "<li class='liGrade3'>". $this->nav->createEntry(3, $nav3) .'</li>';
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
          <li><?php echo html::a('javascript:;', $lang->save, '', "class='btn btn-primary' onclick='return submitForm()'")?></li>
        </ul>
      </td>
    </tr>
  </table>
</form>

<?php /* hidden navSource start .*/ ?>
<div id='grade1NavSource' class='hide'>
  <li class='liGrade1'>
    <?php echo $this->nav->createEntry(1);?>
  </li>
</div>
<div id='grade2NavSource' class='hide'>
  <ul class='ulGrade2'>
    <li class='liGrade2'><?php echo $this->nav->createEntry(2);?></li>
  </ul>
</div>
<div id='grade3NavSource' class='hide'>
  <ul class='ulGrade3'>
    <li class='liGrade3'><?php echo $this->nav->createEntry(3);?></li>
  </ul>
</div>
<?php /* hidden navSource end.*/ ?>

<?php include '../../common/view/footer.admin.html.php';?>
