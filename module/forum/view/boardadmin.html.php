<?php include '../../common/view/header.admin.html.php'; ?>
<div class="row">
  <div class='u-1'>
  <?php echo html::a($this->createLink('tree', 'browse', 'tree=forum'), '模块')?>
  <table class='table-1'>
    <?php $config->requestType = 'PATH_INFO';?>
    <caption>
      <div class='f-left'><?php $header->title;?></div>
      <div class='f-right'><?php if($board) echo html::a($this->createLink('thread', 'post', "boardID=$board->id"), $lang->forum->post, '_blank');?></div>
    </caption>
    <tr>
      <th colspan='2'><? echo $lang->thread->title;?></th>
      <th><?php echo $lang->thread->author;?></th>
      <th><?php echo $lang->thread->postedDate;?></th>
      <th><?php echo $lang->thread->views;?></th>
      <th><?php echo $lang->thread->views;?></th>
      <th colspan='2'><?php echo $lang->thread->lastReply;?></th>
    </tr>  
    <?php foreach($threads as $thread):?>
    <tr class='a-center'>
      <td class='w-10px'>
        <?php
        $iconRoot = $siteTheme . 'images/forum/';
        $thread->isNew ? print(html::image($iconRoot . 'boardnew.gif')) : print(html::image($iconRoot . 'boardcommon.gif'));
        ?>
      </td>
      <td class='a-left'><?php echo html::a($this->createLink('thread', 'view', "id=$thread->id"), $thread->title, '_blank');?></td>
      <td class='a-left w-50px'><?php echo $thread->author;?></td>
      <td class='w-100px'><?php echo substr($thread->addedDate, 5, -3);?></td>
      <td class='w-30px'><?php echo $thread->views;?></td>
      <td class='w-30px'><?php echo $thread->replies;?></td>
      <td class='w-150px a-left'><?php if($thread->replies) echo substr($thread->lastRepliedDate, 5, -3) . ' ' . $thread->lastRepliedBy;?></td>  
    </tr>  
    <?php endforeach;?>
    <?php $config->requestType = 'GET';?>
    <tr><td colspan='8'><?php $pager->show();?></td></tr>
  </table>
</div>
</div>
<?php include '../../common/view/footer.admin.html.php'; ?>
