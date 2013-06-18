<?php include 'header.lite.html.php';?>
<div class="navbar">
  <div class="navbar-inner">
    <div class="navbar-container">
      <a href="/" class="brand"><img src="<?php echo $defaultTheme . '/images/default/xirang_top_logo.png';?>" alt="xirang" /></a>
      <div class="nav-collapse collapse">
        <ul class="nav">
            <li class="active"><a href="/admin.php">首页</a></li>
            <li><?php echo html::a($this->createLink('article', 'browseAdmin'), $lang->admin->manageArticle, 'mainwin');?></li>
            <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="nav-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
        </ul>
        <ul class="nav pull-right">	
          <li><?php echo html::a($this->createLink('site' , 'set') , $lang->admin->setSite);?></li>		
          <li class="divider-vertical"></li>								
          <li><a href="#/logout">退出</a></li>		
        </ul>
      </div><!--/.nav-collapse -->
    </div><!--/.container -->
  </div><!--/.navbar-inner -->    
</div>
