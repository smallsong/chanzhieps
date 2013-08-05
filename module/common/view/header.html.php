<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php 
include 'header.lite.html.php';
if(isset($config->site->logo)) $logo = json_decode($this->config->site->logo);
js::set('lang', $lang->js);
$navs = json_decode($this->config->nav->mainNav, true);
?>
<div class="container">
  <div class="masthead">
    <div class="row">
      <div id="topnav-menu" class="a-right"> <?php echo commonModel::printTopBar();?> </div>
      <div class="span3">
        <?php if(isset($logo)):?><img class="logo" src="<?php echo $logo->webPath?>"/><?php endif;?>
      </div>
      <div class="span9 a-right">
        <div class="slogan">
          <h3><?php echo $config->company->name;?></h3>
          <span><?php echo $this->config->site->slogan;?> </span>
        </div>
      </div>
    </div>
    <div class="navbar">
      <div class="navbar-inner">
        <div class="container">
          <ul class="nav sf-menu sf-js-enabled">

            <?php foreach($navs[1] as $nav):?>
            <li class="cat-item"> 
              <a href="<?php echo $nav['url'];?>"><?php echo $nav['title'];?></a>
              <?php if(isset($navs[2][$nav['key']])):?>
              <ul class="grade2 children">
                <?php foreach($navs[2][$nav['key']] as $nav2):?>
                <li class="cat-item">
                  <a href="<?php echo $nav2['url'];?>"><?php echo $nav2['title'];?></a>
                  <?php if(isset($navs[3][$nav2['key']])):?>
                  <ul class="grade3 children">
                    <?php foreach($navs[3][$nav2['key']] as $nav3):?>
                    <li class="cat-item">
                      <a href="<?php echo $nav3['url'];?>"><?php echo $nav3['title'];?></a>
                    </li>
                    <?php endforeach;?>
                  </ul>
                  <?php endif;?>
                </li>
                <?php endforeach;?>
              </ul>
              <?php endif;?>
            </li>
            <?php endforeach;?>
          </ul>
        </div>
      </div>
    </div>
  </div>
