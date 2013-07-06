<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php 
include 'header.lite.html.php';
$logo = json_decode($this->config->site->logo);
?>
<div class="container">
  <div class="masthead">
    <div class="row">
       <div class="span4"><img class="logo" src="<?php echo $logo->webPath?>"/></div>
       <div class="span8">
         <div class="slogan">
           <h3><?php echo $config->company->name;?></h3>
           <?php echo $this->config->site->slogan;?> 
         </div>
       </div>
    </div>
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
