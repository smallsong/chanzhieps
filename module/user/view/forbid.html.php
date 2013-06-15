<?php
/**
 * The manageanswers view file of article module of XiRangEPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Yangyang Shi <shiyangyangwork@yahoo.cn>
 * @package     User
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class="yui-d0">
  <form method='post' class='u-1'>
    <tr>
      <td>
        <?php echo $lang->user->inputUserName; ?>
        <?php echo html::input('userName', '', 'class=text-3'); ?>
        <?php echo html::submitButton($lang->user->searchUser); ?>
      </td>
    </tr>
  </form>
  <table align='center' class='table-1 fixed'>
    <caption><div class='f-left'><?php echo $lang->user->forbidUser;?></div></caption>
  <tr>
      <th class='w-40px'><?php echo $lang->user->id;?></th>
      <th class='w-80px'><?php echo $lang->user->realname;?></th>
      <th class='w-60px'><?php echo $lang->user->nickname;?></th>
      <th class='w-80px'><?php echo $lang->user->account;?></th>
      <th class='w-40px'><?php echo $lang->user->gendar;?></th>
      <th class='w-120px'><?php echo $lang->user->company;?></th>
      <th class='w-80px'><?php echo $lang->user->join;?></th>
      <th class='w-60px'><?php echo $lang->user->visits;?></th>
      <th class='w-100px'><?php echo $lang->user->last;?></th>
      <th class='w-150px'><?php echo $lang->user->operate;?></th>
    </tr>
    <?php foreach($users as $user):?>
    <tr>
      <td class='a-right'><strong><?php echo $user->id;?></strong></td>
      <td class='a-right'><?php echo $user->realname; ?> </td>
      <td class='a-right'><?php echo $user->nickname; ?> </td>
      <td class='a-right'><?php echo $user->account; ?> </td>
      <td class='a-right'><?php echo $user->gendar; ?> </td>
      <td class='a-right'><?php echo $user->company; ?> </td>
      <td class='a-right'><?php echo $user->join; ?> </td>
      <td class='a-right'><?php echo $user->visits; ?> </td>
      <td class='a-right'><?php echo $user->last; ?> </td>
      <td>
        <?php 
          echo $lang->user->forbid;
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
    <tr><td colspan='10' class='a-right'><?php $pager->show();?></td></tr>
  </table>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
