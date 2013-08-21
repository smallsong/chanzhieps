<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<?php if($slides):?>
<div id='slide' class='carousel slide'>
  <div class='carousel-inner'>
    <?php foreach($slides as $slide):?>
    <div class='item'>
      <?php echo html::image($slide->image);?>
      <div class='container'>
        <div class='carousel-caption'>
          <h2><?php echo $slide->title;?></h2>
          <div class='lead'><?php echo $slide->summary;?></div>
          <?php if(trim($slide->label) != '') echo html::a($slide->url, $slide->label, '', "class='btn btn-large btn-primary'");?>
        </div>
      </div>
    </div>
    <?php endforeach;?>
  </div>
  <?php echo html::a('#slide', $lang->prev, '', "class='left carousel-control' data-slide='prev'")?>
  <?php echo html::a('#slide', $lang->next, '', "class='right carousel-control' data-slide='next'")?>
</div>
<?php endif;?>

<div class='row-fluid'>
  <div class='col-md-4'>
    <div class="panel radius">
      <h4><?php echo $lang->index->aboutus;?></h4>
      <p><?php echo $this->config->company->desc;?><?php echo html::a($this->createLink('company', 'index'), $lang->more . $lang->raquo);?></p>
    </div>
  </div>

  <div class='col-md-4'>
    <div class="panel radius">
      <h4><?php echo $lang->index->news;?></h4>
      <ul class='mg-zero'>
        <?php foreach($latestArticles as $id => $article): ?>
        <li>
            <i class='icon-chevron-right'></i>
            <?php echo html::a($this->createLink('article','view', "id=$id"), $article, '', "class='latest-news' title='{$article}'");?>
        </li>
        <?php endforeach;?>
      </ul>
    </div>
  </div>

  <div class='col-md-4'>
    <div id='contact' class="panel radius">
      <h4><?php echo $lang->index->contact;?></h4>
      <?php foreach($contact as $item => $value):?>
      <dl>
        <dt><?php echo $this->lang->company->$item . $lang->colon;?></dt>
        <dd><?php echo $value;?></dd>
        <div class='c-both'></div>
      </dl>
      <?php endforeach;?>
      <div class='c-both'></div>
    </div>
  </div>

</div>
<?php include '../../common/view/footer.html.php';?>
