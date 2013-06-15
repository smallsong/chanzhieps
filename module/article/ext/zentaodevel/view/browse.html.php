<?php include '../../../../common/view/header.html.php';?>
<div class='span12'>
  <table class='table table-hover'>
    <caption><?php echo $module->name;?></caption>
    <?php foreach($articles as $article):?>
    <tr>
      <td>
        <?php 
        if('rssarticle' == $module->tree){ echo html::a($article->link, $article->title, '_blank', "class£½'colorbox'"); }
        else { echo html::a(inlink('view', "id=$article->id"), $article->title); }
        ?>
      </td>
      <td width='50'><?php echo substr($article->addedDate, 2, 8);?></td>
    </tr>
    <?php endforeach;?>
    <tr><td colspan='2'><?php $pager->show('right', 'short');?></td></tr>
  </table>
</div>
<?php include '../../../../common/view/footer.html.php';?>

