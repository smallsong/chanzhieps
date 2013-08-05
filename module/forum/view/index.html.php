<?php include '../../common/view/header.html.php'; ?>
<?php $common->printPositionBar();?>
<div class='row-fluid' id='forum'>
  <?php foreach($boards as $parentBoard):?>
  <table class='table-1'>
    <caption class='caption-bold'><?php echo $parentBoard->name;?></caption>
    <tr>
      <th colspan='2'><?php echo $lang->forum->board;?></th>
      <th><?php echo $lang->forum->owners;?></th>
      <th><?php echo $lang->forum->threadCount;?></th>
      <th><?php echo $lang->forum->postCount;?></th>
      <th><?php echo $lang->forum->lastPost;?></th>
    </tr>  
    <?php foreach($parentBoard->childs as $childBoard):?>
    <tr valign='middle' class='a-center'>
      <td class='w-20px'><?php echo $this->forum->isNew($childBoard) ? "<span class='new-board'>&nbsp;</span>" : "<span class='common-board'>&nbsp;</span>"; ?></td>
      <td class='a-left'>
        <strong><?php echo html::a(inlink('board', "id=$childBoard->id"), $childBoard->name);?></strong><br />
        <i><?php echo $childBoard->desc;?></i>
      </td>
      <td class='w-50px strong'><nobr><?php echo trim($childBoard->owners, ',');?></nobr></td>
      <td class='w-70px'><?php echo $childBoard->threads;?></td>
      <td class='w-70px'><?php echo $childBoard->posts;?></td>
      <td class='w-150px a-center'>
        <?php
        $recTotal   = $childBoard->lastPostReplies;
        $recPerPage = 20;
        $pageID     = (int)($recTotal / $recPerPage) + 1;
        $threadLink = $this->createLink('thread', 'view', "threadID=$childBoard->lastPostID&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID") . "#$childBoard->lastReplyID";

        echo html::a($threadLink, substr($childBoard->lastPostedDate, 2)) . '<br />';
        echo $childBoard->lastPostedBy;
        ?>
      </td>
    </tr>  
    <?php endforeach;?>
  </table>
  <?php endforeach;?>   
</div>
<?php include '../../common/view/footer.html.php'; ?>
