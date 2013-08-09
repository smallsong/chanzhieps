<?php include '../../common/view/header.html.php'; ?>
<?php include '../../common/view/treeview.html.php'; ?>
<?php $LatestArticles =  articleModel::getLatest(0,8);?>
<div id="myCarousel" class="carousel slide">
  <div class="carousel-inner">
    <div class="item active">
      <img src="http://www.bootcss.com/assets/img/examples/slide-01.jpg" alt="">
      <div class="container">
        <div class="carousel-caption">
          <h1>息壤 EPS 门户系统</h1>
          <p class="lead">Cras justo odio, dapibus ac facilisis in, 
            egestas eget quam. Donec id elit non mi porta gravida at eget metus. 
            Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
          <a class="btn btn-large btn-primary" href="#">Sign up today</a>
        </div>
      </div>
    </div>
    <div class="item">
      <img src="http://www.bootcss.com/assets/img/examples/slide-02.jpg" alt="">
      <div class="container">
        <div class="carousel-caption">
          <h1>Another example headline.</h1>
          <p class="lead">Cras justo odio, dapibus ac facilisis in, 
            egestas eget quam. Donec id elit non mi porta gravida at eget metus. 
            Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
          <a class="btn btn-large btn-primary" href="#">Learn more</a>
        </div>
      </div>
    </div>
  </div>
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
</div>
<div class="row-fluid">
  <div class="span4">
    <h4><?php echo $lang->index->aboutus;?></h4>
    <p><?php echo $this->config->company->desc;?></p>
    <p><?php echo html::a($this->createLink('company', 'index'), '更多', '', "class='btn btn-info'");?></p>
  </div>
  <div class="span4">
    <h4><?php echo $lang->index->news;?></h4>
    <?php foreach($LatestArticles as $id => $article): ?>
      <p><i class="icon-chevron-right"></i><?php echo html::a($this->createLink('article','view', "id=$id"), $article, '', "class='latest-news'");?></p>
    <?php endforeach; ?>
  </div>
  <div class="span4">
    <h4><?php echo $lang->index->contact;?></h4>
    <ul><?php $this->loadModel('common')->getContact();?></ul>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>
