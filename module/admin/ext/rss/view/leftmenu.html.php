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
        echo $treeMenu;
        echo '<br />';

        echo html::a($this->createLink('rssarticle', 'review'), $lang->admin->reviewArticle, 'mainwin') . '<br />';
        echo html::a($this->createLink('rssfeed',    'mapCategory'), $lang->admin->mapCategory, 'mainwin') . '<br /><br />';

        echo html::a($this->createLink('rssarticle', 'browseAdmin'), $lang->admin->allArticles, 'mainwin') . '<br />';
        echo html::a($this->createLink('rssfeed',    'browseAdmin'), $lang->admin->allFeeds,    'mainwin') . '<br /><br />';

        echo html::a($this->createLink('rssarticle', 'trash'), $lang->admin->trash, 'mainwin') . '<br /><br />';

        echo html::a($this->createLink('tree', 'browse', "view=$tree"), $lang->tree->manage, 'mainwin');
        echo html::a($this->createLink('tree', 'fix',    "view=$tree"), $lang->tree->fix, 'mainwin');
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
       ?>
     </td>
    </tr>
  </table>
<?php include '../../../../common/view/footer.admin.html.php';?>
