<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php 
include 'header.lite.html.php';
if(isset($config->site->logo)) $logo = json_decode($this->config->site->logo);
js::set('lang', $lang->js);
$menus = json_decode($this->config->menu->mainMenu, true);
$current = commonModel::getCurrentMenu($moduleName);
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

            <?php foreach($menus[1] as $menu):?>
            <li class="cat-item"> 
              <a href="<?php echo $menu['url'];?>"><?php echo $menu['title'];?></a>
              <?php if(isset($menus[2][$menu['key']])):?>
              <ul class="grade2 children">
                <?php foreach($menus[2][$menu['key']] as $menu2):?>
                <li class="cat-item">
                  <a href="<?php echo $menu2['url'];?>"><?php echo $menu2['title'];?></a>
                  <?php if(isset($menus[3][$menu2['key']])):?>
                  <ul class="grade3 children">
                    <?php foreach($menus[3][$menu2['key']] as $menu3):?>
                    <li class="cat-item">
                      <a href="<?php echo $menu3['url'];?>"><?php echo $menu3['title'];?></a>
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
