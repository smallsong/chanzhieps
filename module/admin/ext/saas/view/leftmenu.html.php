<?php include '../../../../common/view/header.admin.html.php';?>
<?php include '../../../../common/view/treeview.html.php';?>
<script language='Javascript'>
var site = '<?php echo $session->site->id;?>';
</script>
<body>
  <table class='table-1' align='center'>
    <caption><?php echo $session->site->name . $lang->colon . $lang->admin->manageArticle?> </caption>
    <tr>
      <td>
        <?php 
        echo html::select('tree', $lang->tree->lists, $tree, 'class="select-1" onchange="loadTree()"');
        echo $treeMenu;
        if($tree != 'forum') echo html::a($this->createLink('article', 'browseAdmin', "tree=$tree"), $lang->admin->allArticles, 'mainwin');
        if($tree == 'forum') echo html::a($this->createLink('forum', 'boardAdmin'), $lang->admin->allArticles, 'mainwin');
        echo html::a($this->createLink('tree', 'browse', "view=$tree"), $lang->tree->manage, 'mainwin');
        ?>
      </td>
    </tr>
  </table>
  <table class='table-1' align='center'>
    <caption><?php echo $lang->admin->basicManage;?></caption>
    <tr>
     <td class='a-center' id='basic'>
       <?php
       echo '<p>' . html::a($this->createLink('site',  'set' ),   $lang->admin->setSite, 'mainwin') . '</p>';
       echo '<p>' . html::a($this->createLink('block', 'browse'), $lang->admin->manageBlock, 'mainwin') . '</p>';
       echo '<p>' . html::a($this->createLink('comment', 'getlatest'), $lang->admin->manageComment, 'mainwin') . '</p>';
       echo '<p>' . html::a($this->createLink('forum', 'updateStats'), $lang->admin->updateForum, 'mainwin') . '</p>';
       ?>
     </td>
    </tr>
  </table>
<?php include '../../../../common/view/footer.admin.html.php';?>
