<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<div id="myCarousel" class="carousel slide">
  <div class="carousel-inner">
    <?php foreach($slides as $slide):?>
    <div class="item">
      <?php echo html::image($slide->image);?>
      <div class="container">
        <div class="carousel-caption">
          <h2><?php echo $slide->title;?></h2>
          <p class="lead"><?php echo $slide->summary;?></p>
          <?php echo html::a($slide->url, $slide->label, '', "class='btn btn-large btn-primary'");?>
        </div>
      </div>
    </div>
    <?php endforeach;?>
  </div>
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
</div>
<div class="row-fluid">

  <div class="span4">
    <h4><?php echo $lang->index->aboutus;?></h4>
    <p><?php echo $this->config->company->desc;?></p>
    <p><?php echo html::a($this->createLink('company', 'index'), $lang->more, '', "class='btn btn-info'");?></p>
  </div>

  <div class="span4">
    <h4><?php echo $lang->index->news;?></h4>
    <?php foreach($latestArticles as $id => $article): ?>
    <p>
        <i class="icon-chevron-right"></i>
        <?php echo html::a($this->createLink('article','view', "id=$id"), $article, '', "class='latest-news'");?>
    </p>
    <?php endforeach;?>
  </div>

  <div class="span4">
    <h4><?php echo $lang->index->contact;?></h4>
    <ul><?php $this->loadModel('common')->getContact();?></ul>
  </div>

</div>
<?php include '../../common/view/footer.html.php';?>
