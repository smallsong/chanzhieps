<?php include '../../common/view/header.html.php'; ?>
<?php $common->printPositionBar();?>
<?php foreach($boards as $parentBoard):?>
<table class='table table-form table-hover table-striped'>
  <caption><?php echo $parentBoard->name;?></caption>
  <thead>
    <tr class='a-center'>
      <th class='a-center' colspan='2'><?php echo $lang->forum->board;?></th>
      <th><?php echo $lang->forum->owners;?></th>
      <th><?php echo $lang->forum->threadCount;?></th>
      <th><?php echo $lang->forum->postCount;?></th>
      <th><?php echo $lang->forum->lastPost;?></th>
    </tr>  
  </thead>
  <tbody>
    <?php foreach($parentBoard->childs as $childBoard):?>
    <tr valign='middle' class='a-center'>
      <td class='w-20px'><?php echo $this->forum->isNew($childBoard) ? "<span class='new-board'>&nbsp;</span>" : "<span class='common-board'>&nbsp;</span>"; ?></td>
      <td class='a-left'>
        <strong><?php echo html::a(inlink('board', "id=$childBoard->id"), $childBoard->name);?></strong><br />
        <i><?php echo $childBoard->desc;?></i>
      </td>
      <td class='w-50px strong'><nobr><?php echo trim($childBoard->moderators, ',');?></nobr></td>
      <td class='w-70px'><?php echo $childBoard->threads;?></td>
      <td class='w-70px'><?php echo $childBoard->posts;?></td>
      <td class='w-150px a-left'>
        <?php
        $recTotal   = $childBoard->lastPostReplies;
        $recPerPage = 20;
        $pageID     = (int)($recTotal / $recPerPage) + 1;
        $threadLink = $this->createLink('thread', 'view', "threadID=$childBoard->postID&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID") . "#$childBoard->replyID";

        echo substr($childBoard->postedDate, 5, -3) . ' ' . $childBoard->postedBy;
        ?>
      </td>
    </tr>  
    <?php endforeach;?>
  </tbody>
</table>
<?php endforeach;?>   
<?php include '../../common/view/footer.html.php'; ?>
