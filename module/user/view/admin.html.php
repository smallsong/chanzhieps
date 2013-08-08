<?php
/**
 * The manageanswers view file of article module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Yangyang Shi <shiyangyangwork@yahoo.cn>
 * @package     User
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<form method='post' class='form-inline mb-10px form-search pull-right'>
  <?php echo html::input('userName', '', "class='text-2 input-medium search-query' placeholder='{$lang->user->inputUserName}'"); ?>
  <?php echo html::submitButton($lang->user->searchUser, 'btn'); ?>
</form>
<table class='table table-hover table-striped'>
  <caption><?php echo $lang->user->userList;?></caption>
  <thead>
    <tr class='a-center'>
      <th class='w-id'><?php echo $lang->user->id;?></th>
      <th class='w-80px'><?php echo $lang->user->realname;?></th>
      <th class='w-80px'><?php echo $lang->user->nickname;?></th>
      <th class='w-80px'><?php echo $lang->user->account;?></th>
      <th class='w-60px'><?php echo $lang->user->gendar;?></th>
      <th class='a-left'><?php echo $lang->user->company;?></th>
      <th class='w-150px'><?php echo $lang->user->addedDate;?></th>
      <th class='w-80px'><?php echo $lang->user->visits;?></th>
      <th class='w-150px'><?php echo $lang->user->last;?></th>
      <th><?php echo $lang->user->forbid;?></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($users as $user):?>
  <tr class='a-center'>
    <td class='a-center'><?php echo $user->id;?></td>
    <td><?php echo $user->realname; ?> </td>
    <td><?php echo $user->nickname; ?> </td>
    <td><?php echo $user->account; ?> </td>
    <td><?php $gendar = $user->gendar; echo $lang->user->gendarList->$gendar; ?> </td>
    <td class='a-left'><?php echo $user->company; ?> </td>
    <td><?php echo $user->addedDate; ?> </td>
    <td><?php echo $user->visits; ?> </td>
    <td><?php echo $user->last; ?> </td>
    <td class="operate">
      <?php 
      foreach($lang->user->forbidDate as $date => $title)
      {
          echo html::a($this->createLink('user', 'forbid', "date=$date&userID=$user->id"), $title);
      }
      ?>
    </td>
  </tr>
  <?php endforeach;?>
  </tbody>
  <tfoot><tr><td colspan='10' class='a-right'><?php $pager->show();?></td></tr></tfoot>
</table>
<?php include '../../common/view/footer.admin.html.php';?>
