<?php include '../../common/view/header.html.php';?>
<?php $common->printPositionBar('', '', $lang->help->donation);?>
<div class='row'>
  <div class='u-24-5'>
    <div class='cont-left'>
      <div class='box-title'><?php echo $lang->donation->useMoney?></div>
      <div class='box-content'><?php echo $lang->donation->notice?></div>
    </div>
  </div>
  <div class='u-24-19'>
    <div id='doccontent'>
      <h1 align='center'><?php echo $lang->help->donation;?></h1>
      <form target='hiddenwin' method='post'>
      <table align='center' class='table-1'>
        <tr align='left'>
          <?php if($this->app->user->account == 'guest'):?>
          <td colspan='2'><?php echo sprintf($lang->donation->nologin, $this->createLink('user', 'login'))?></td>
          <?php else:?>
          <td colspan='2'><?php echo sprintf($lang->donation->welcome, $this->app->user->account)?></td>
          <?php endif;?>
        </tr>
        <tr>
          <th><?php echo $lang->donation->money?></th>
          <td><?php echo html::select('money', $lang->donation->moneyList, 100, "class='w-200px'") . $lang->rmb;?></td>
        </tr>
        <tr>
          <th><?php echo $lang->donation->name?></th>
          <td><?php echo html::input('name', $this->app->user->account == 'guest' ? '' : $this->app->user->account, "class='w-200px'")?></td>
        </tr>
        <tr>
          <th><?php echo $lang->donation->email?></th>
          <td><?php echo html::input('email', $this->app->user->account == 'guest' ? '' : $this->app->user->email, "class='w-200px'")?></td>
        </tr>
        <tr>
          <th><?php echo $lang->donation->site?></th>
          <td><?php echo html::input('site', $this->app->user->account == 'guest' ? '' : $this->app->user->webSite, "class='w-200px'")?></td>
        </tr>
        <tr>
          <th><?php echo $lang->donation->anonymity?></th>
          <td><?php echo html::radio('anonymous', $lang->donation->anonymityList)?></td>
        </tr>
        <tr><td colspan='2' align='center'><?php echo html::submitButton($lang->help->donation)?></td></tr>
      </table>
      </form>
      <?php if($donors):?>
      <table class='table-1' align='center'>
        <caption><?php echo $lang->donation->donorList?></caption>
        <tr>
          <th width='30%'><?php echo $lang->donation->time?></th>
          <th><?php echo $lang->donation->donorMan?></th>
          <th width='30%'><?php echo $lang->donation->price?></th>
        </tr>
        <?php foreach($donors as $donor):?>
        <tr align='center'>
          <td><?php echo $donor->paidDate?></td>
          <td>
          <?php 
          $name = $donor->anonymous ? $lang->donation->guest : ($donor->account == 'guest' ? $lang->donation->guest : $donor->name);
          echo $donor->site ? html::a($donor->site, $name, '_blank') : $name;
          ?>
          </td>
          <td><?php echo $donor->money . $lang->rmb?></td>
        </tr>
        <?php endforeach;?>
      </table>
      <?php endif;?>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
