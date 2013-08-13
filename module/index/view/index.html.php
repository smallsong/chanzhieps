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
          <p class='lead'><?php echo $slide->summary;?></p>
          <?php echo html::a($slide->url, $slide->label, '', "class='btn btn-large btn-primary'");?>
        </div>
      </div>
    </div>
    <?php endforeach;?>
  </div>
  <?php echo html::a('#slide', $lang->slide->prev, '', "class='left carousel-control' data-slide='prev'")?>
  <?php echo html::a('#slide', $lang->slide->next, '', "class='right carousel-control' data-slide='next'")?>
</div>
<?php endif;?>

<div class='row-fluid'>
  <div class='span4'>
    <h4><?php echo $lang->index->aboutus;?></h4>
    <p><?php echo $this->config->company->desc;?></p>
    <p><?php echo html::a($this->createLink('company', 'index'), $lang->more, '', "class='btn btn-info'");?></p>
  </div>

  <div class='span4'>
    <h4><?php echo $lang->index->news;?></h4>
    <?php foreach($latestArticles as $id => $article): ?>
    <p>
        <i class='icon-chevron-right'></i>
        <?php echo html::a($this->createLink('article','view', "id=$id"), $article, '', "class='latest-news'");?>
    </p>
    <?php endforeach;?>
  </div>

  <div class='span4'>
    <h4><?php echo $lang->index->contact;?></h4>
    <?php foreach($contact as $item => $value):?>
    <dl>
      <dt class='w-p20 f-left pb-10px a-right'><?php echo $this->lang->company->$item . $lang->colon;?></dt>
      <dd class='w-p70 f-left pb-10px'><?php echo $value;?></dd>
    </dl>
    <?php endforeach;?>
    <div class='c-both'></div>
  </div>

</div>
<?php include '../../common/view/footer.html.php';?>
