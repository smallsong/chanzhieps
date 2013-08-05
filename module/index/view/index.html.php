<?php include '../../common/view/header.html.php'; ?>
<?php include '../../common/view/treeview.html.php'; ?>
<?php $LatestArticles =  articleModel::getLatest(0,8);
      $contact        = json_decode($this->config->company->contact);
?>
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
  <div class="span3">
  <h2>品牌宣传</h2>
  <p>我们是息壤的开发团队， 我们在开发一款开源的企业门户系统， 我们在着力解决企业宣传营销的问题， 我们在从事一项非常具有价值的事业， 我们是一个年轻的团队， 我们相信人性本善， 我们非常看重人与人之间的信任， 我们坦率真诚，不善欺骗， 我们非常乐意分享利益， 我们在美丽的青岛开发区， 我们在等待着您的加入！</p>
  </div>
  <div class="span3">
  <h2>营销推广</h2>
  <p>我们是息壤的开发团队， 我们在开发一款开源的企业门户系统， 我们在着力解决企业宣传营销的问题， 我们在从事一项非常具有价值的事业， 我们是一个年轻的团队， 我们相信人性本善， 我们非常看重人与人之间的信任， 我们坦率真诚，不善欺骗， 我们非常乐意分享利益， 我们在美丽的青岛开发区， 我们在等待着您的加入！</p>
  </div>
  <div class="span3">
  <h2>电子商务</h2>
  <p>我们是息壤的开发团队， 我们在开发一款开源的企业门户系统， 我们在着力解决企业宣传营销的问题， 我们在从事一项非常具有价值的事业， 我们是一个年轻的团队， 我们相信人性本善， 我们非常看重人与人之间的信任， 我们坦率真诚，不善欺骗， 我们非常乐意分享利益， 我们在美丽的青岛开发区， 我们在等待着您的加入！</p>
  </div>
  <div class="span3">
  <h2>客户关怀</h2>
  <p>我们是息壤的开发团队， 我们在开发一款开源的企业门户系统， 我们在着力解决企业宣传营销的问题， 我们在从事一项非常具有价值的事业， 我们是一个年轻的团队， 我们相信人性本善， 我们非常看重人与人之间的信任， 我们坦率真诚，不善欺骗， 我们非常乐意分享利益， 我们在美丽的青岛开发区， 我们在等待着您的加入！</p>
  </div>
</div>
<div class="row-fluid">
  <div class="span4">
    <h2><?php echo $lang->index->aboutus;?></h2>
    <p><?php echo $this->config->company->desc;?></p>
    <p><?php echo html::a($this->createLink('company', 'index'), '更多', '', "class='btn btn-info'");?></p>
  </div>
  <div class="span4">
    <h2><?php echo $lang->index->news;?></h2>
    <?php foreach($LatestArticles as $id => $article): ?>
      <p><i class="icon-chevron-right"></i><?php echo html::a($this->createLink('article','view', "id=$id"), $article, '', "class='latest-news'");?></p>
    <?php endforeach; ?>
  </div>
  <div class="span4">
    <h2><?php echo $lang->index->contact;?></h2>
    <?php foreach($contact as $item => $value):?>
    <?php if($value == "") continue;?>
    <p><strong><?php echo $lang->company->$item;?>:</strong><?php echo $value;?></p>
    <?php endforeach;?>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>
