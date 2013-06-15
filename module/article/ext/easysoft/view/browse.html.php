<?php include '../../../../common/view/header.html.php';?>
<div class='blockBox' id='dynamic'>
  <div class='block4x3' style='background:#eee; overflow:auto;'>
    <table class='table table-striped table-hover'>
      <caption><?php echo $module->name;?></caption>
      <?php foreach($articles as $article):?>
      <tr>
        <td><?php echo html::a(inlink('view', "id=$article->id"), $article->title);?></td>
        <td width='50'><?php echo substr($article->addedDate, 2, 8);?></td>
      </tr>
      <?php endforeach;?>
    </table>
    <div><?php $pager->show('right', 'short');?></div>
  </div>
</div>  
<?php include '../../../../common/view/footer.html.php';?>
