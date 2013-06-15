<?php include '../../../../common/view/header.html.php';?>
<div id="myCarousel" class="carousel" data-interval="0">  
  <ol class="carousel-indicators">  
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>  
    <li data-target="#myCarousel" data-slide-to="1"></li>  
    <li data-target="#myCarousel" data-slide-to="2"></li>  
    <li data-target="#myCarousel" data-slide-to="3"></li>  
    <li data-target="#myCarousel" data-slide-to="4"></li>  
  </ol>  
  <!-- Carousel items -->  
  <div class="carousel-inner">  
    <div class="<?php if($moduleID == 0)    echo 'active';?> item"><?php include './all.html.php';?></div>
    <div class="<?php if($moduleID == $this->config->index->modules['products']) echo 'active';?> item">
      <?php include './products.html.php';?>
    </div>  
    <div class="<?php if($moduleID == $this->config->index->modules['services']) echo 'active';?> item">
      <?php include './services.html.php';?>
    </div>  
    <div class="item">
      <?php include './dynamic.html.php';?>
    </div>  
    <div class="<?php if($moduleID == $this->config->index->modules['aboutUs']) echo 'active';?> item">
      <?php include './aboutus.html.php';?>
    </div>  
  </div>  
<div>
  <a class="carousel-control left" href="#myCarousel" data-slide-to="0">&lsaquo;</a>  
  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>  
</div>
</div>  
<?php include '../../../../common/view/footer.html.php';?>
