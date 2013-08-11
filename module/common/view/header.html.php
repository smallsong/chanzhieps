<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php 
include 'header.lite.html.php';
if(isset($config->site->logo)) $logo = json_decode($this->config->site->logo);
js::set('lang', $lang->js);

$topNavs = $this->loadModel('nav')->getNavs('mainNav');
?>
<div class="container">
  <div class="masthead">
    <div class="row">
      <div id="topnav-menu" class="a-right"> <?php echo commonModel::printTopBar();?> </div>
      <?php if(isset($logo)):?>
      <div class="span3">
        <img class="logo" src="<?php echo $logo->webPath?>" />
      </div>
      <div class='span9 a-right'>
        <div class="slogan">
          <h3><?php echo $config->company->name;?></h3>
          <span><?php echo $this->config->site->slogan;?></span>
        </div>
      </div>
      <?php else:?>
      <div class='span4'><h3><?php echo $config->company->name;?></h3></div>
      <div class='span8 ml-zero mt-20px f-right'><?php echo $this->config->site->slogan;?></div>
      <?php endif;?>
    </div>
    <div class="navbar">
      <div class="navbar-inner">
        <div class="container">
          <ul id="topNav" class="nav sf-menu sf-js-enabled">
            <?php foreach($topNavs as $nav1):?>
            <li class="cat-item <?php echo $nav1->class?>"> 
              <?php echo html::a($nav1->url, $nav1->title);?>
              <?php if(!empty($nav1->children)):?>
              <ul class="grade2 children">
                <?php foreach($nav1->children as $nav2):?>
                <li class="cat-item <?php echo $nav2->class?>">
                  <?php echo html::a($nav2->url, $nav2->title);?>
                  <?php if(!empty($nav2->children)):?>
                  <ul class="grade3 children">
                    <?php foreach($nav2->children as $nav3):?>
                    <li class="cat-item"> <?php echo html::a($nav3->url, $nav3->title);?> </li>
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
