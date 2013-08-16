<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php 
include 'header.lite.html.php';

if(isset($config->site->logo)) $logo = json_decode($this->config->site->logo);
js::set('lang', $lang->js);

$topNavs = $this->loadModel('nav')->getNavs('top');
?>
<div class='container'>
    <div class='row'>
      <div class='a-right'> <?php echo commonModel::printTopBar();?> </div>
      <?php if(isset($logo)):?>
      <div class='span3' id='logoBox'>
        <?php echo html::a($this->config->webRoot, html::image($logo->webPath, "class='logo' title='{$this->config->company->name}'"));?>
      </div>
      <div class='span9'>
        <p id='slogan'><?php echo $this->config->site->slogan;?></p>
      </div>
      <?php else:?>
      <div class='span4'><h3><?php echo $config->company->name;?></h3></div>
      <div id='slogan' class='span8'><?php echo $this->config->site->slogan;?></div>
      <?php endif;?>
    </div>
    <div id='topNav' class='navbar navbar-inverse'>
      <div class='navbar-inner'>
        <div class='container'>
          <ul class='nav sf-menu sf-js-enabled grade1'>
            <?php foreach($topNavs as $nav1):?>
            <li class="cat-item <?php echo $nav1->class?>"> 
              <?php echo html::a($nav1->url, $nav1->title);?>
              <?php if(!empty($nav1->children)):?>
              <ul class='grade2 children'>
                <?php foreach($nav1->children as $nav2):?>
                <li class="cat-item <?php echo $nav2->class?>">
                  <?php echo html::a($nav2->url, $nav2->title);?>
                  <?php if(!empty($nav2->children)):?>
                  <ul class='grade3 children'>
                    <?php foreach($nav2->children as $nav3):?>
                    <li class='cat-item'><?php echo html::a($nav3->url, $nav3->title);?></li>
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
