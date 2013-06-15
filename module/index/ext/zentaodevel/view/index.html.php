<?php include '../../../../common/view/header.html.php';?>
<div class='container'>
  <div class="hero-unit">
    <h2>禅道开发者中心</h2>
    <p>禅道开发者中心是为禅道二次开发人员提供的文档查看，交流分享的平台！</p>
    <p>
      <a href="http://local.devel.zentao.net/help-book-zentaophphelp" class="btn btn-primary btn-large">文档 &raquo;</a>
      <a href="http://local.devel.zentao.net/article-view-79390.html" class="btn btn-primary btn-large">框架下载 &raquo;</a>
    </p>
  </div>
  <div class="row">
    <div class="span4">
      <h2>框架优点</h2>
        <p>
         禅道项目管理软件底层开发框架  <br />
         完整支持MVC模式，结构合理，易于扩展 <br />
         使用灵活方便，代码简洁优雅 <br />
         完全放弃版权，可任意使用处理 <br />
        </p>
        <p><a class="btn" href="http://local.devel.zentao.net/help-book-zentaophphelp">详情&raquo;</a></p>
    </div>
    <div class="span4">
      <h2>视频教程</h2>
      <p>
        <?php foreach($articles[1233] as $article):?>
         <div><?php echo html::a($this->createLink('article', 'view', "articleID=$article->id"), $article->title) . substr($article->addedDate, 2, 8);?></div>
        <?php endforeach;?>
      </p>
      <p><?php echo html::a($this->createLink('article', 'browse', "moduleID=1233"), '更多&raquo', '', "class='btn'");?></p>
    </div>
    <div class="span4">
      <h2>最新动态</h2>
      <p>
        <?php $articles[1221] = array_slice($articles[1221], 5);?>
        <?php foreach($articles[1221] as $article):?>
         <div><?php echo html::a($this->createLink('article', 'view', "articleID=$article->id"), $article->title) . substr($article->addedDate, 2, 8);?></div>
        <?php endforeach;?>
      </p>
      <p><?php echo html::a($this->createLink('article', 'browse', "moduleID=1221"), '更多&raquo', '', "class='btn'");?></p>
    </div>
  </div>
</div>
<?php include '../../../../common/view/footer.html.php';?>

