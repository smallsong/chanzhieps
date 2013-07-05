<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php include 'header.lite.html.php';?>
<div class="container">
  <div class="masthead">
    <h3 class="muted"><?php echo $config->company->name;?></h3>
    <div class="navbar">
      <div class="navbar-inner">
        <div class="container">
          <ul class="nav">
            <li class="active"><a href="#">首页</a></li>
            <li><a href="#">关于我们</a></li>
            <li><a href="#">新闻动态</a></li>
            <li><a href="#">招聘信息</a></li>
            <li><a href="#">联系我们</a></li>
          </ul>
        </div>
      </div>
    </div><!-- /.navbar -->
  </div>
<style>
body {
    padding-bottom: 60px;
    padding-top: 20px;
}
.container {margin: 0 auto; max-width: 1000px;}
.navbar .navbar-inner {padding: 0;}
.navbar .nav {display: table; margin: 0; width: 100%;}
.navbar .nav li {display: table-cell; float: none; width: 1%;}
.navbar .nav li a {border-left: 1px solid rgba(255, 255, 255, 0.75); border-right: 1px solid rgba(0, 0, 0, 0.1); font-weight: bold; text-align: center;}
.navbar .nav li:first-child a {border-left: 0 none; border-radius: 3px 0 0 3px;}
.navbar .nav li:last-child a {border-radius: 0 3px 3px 0; border-right: 0 none;}
</style>
