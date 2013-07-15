<?php
/**
 * The manageanswers view file of article module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Yangyang Shi <shiyangyangwork@yahoo.cn>
 * @package     User
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class="yui-d0">
  <form method='post' class='form-inline'>
    <tr>
      <td>
        <?php echo $lang->user->inputUserName; ?>
        <?php echo html::input('userName', '', 'class=text-3'); ?>
        <?php echo html::submitButton($lang->user->searchUser); ?>
      </td>
    </tr>
  </form>
  <table align='center' class='table table-hover table-list table-striped'>
    <caption><?php echo $lang->user->forbidUser;?></caption>
  <tr>
      <th class='w-40px'><?php echo $lang->user->id;?></th>
      <th class='w-60px'><?php echo $lang->user->realname;?></th>
      <th class='w-60px'><?php echo $lang->user->nickname;?></th>
      <th class='w-80px'><?php echo $lang->user->account;?></th>
      <th class='w-30px'><?php echo $lang->user->gendar;?></th>
      <th class='w-120px'><?php echo $lang->user->company;?></th>
      <th class='w-100px'><?php echo $lang->user->addedDate;?></th>
      <th class='w-50px'><?php echo $lang->user->visits;?></th>
      <th class='w-100px'><?php echo $lang->user->last;?></th>
      <th class='w-150px'><?php echo $lang->user->forbid;?></th>
    </tr>
    <tbody>
    <?php foreach($users as $user):?>
    <tr>
      <td><?php echo $user->id;?></td>
      <td><?php echo $user->realname; ?> </td>
      <td><?php echo $user->nickname; ?> </td>
      <td><?php echo $user->account; ?> </td>
      <td><?php $gendar = $user->gendar; echo $lang->user->gendarList->$gendar; ?> </td>
      <td><?php echo $user->company; ?> </td>
      <td><?php echo $user->addedDate; ?> </td>
      <td><?php echo $user->visits; ?> </td>
      <td><?php echo $user->last; ?> </td>
      <td class="operate">
        <?php 
          echo html::a($this->createLink('user' ,'forbid' ,"date=oneday&userID=$user->id"),$lang->user->forbidoneday); 
          echo html::a($this->createLink('user' ,'forbid' ,"date=twodays&userID=$user->id" ),$lang->user->forbidtwodays); 
          echo html::a($this->createLink('user' ,'forbid' ,"date=threedays&userID=$user->id" ),$lang->user->forbidthreedays); 
          echo html::a($this->createLink('user' ,'forbid' ,"date=oneweek&userID=$user->id" ),$lang->user->forbidoneweek); 
          echo html::a($this->createLink('user' ,'forbid' ,"date=onemonth&userID=$user->id" ),$lang->user->forbidonemonth); 
          echo html::a($this->createLink('user' ,'forbid' ,"date=forever&userID=$user->id" ),$lang->user->forbidforever); 
        ?>
      </td>
    </tr>
    <?php endforeach;?>
    </tbody>
    <tr><td colspan='10' class='a-right'><?php $pager->show();?></td></tr>
  </table>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
