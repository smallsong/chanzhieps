<?php
$contact    = json_decode($this->config->company->contact);
$sideCategoryMenus =  $this->loadModel('tree')->getSons(0);
?>
  <div class="span3">
    <div class="sidebar"> 
 
      <div class="widget widget-category"> 
        <h2><?php echo $lang->categoryMenu;?></h2>
        <ul>
        <?php foreach($sideCategoryMenus as $category):?>
        <li><?php echo html::a($this->createLink('article', 'browse', "categoryID={$category->id}"), $category->name, '', "id='category{$category->id}' class='btn'");?></li>
        <?php endforeach;?>
        </ul>
      </div>

      <div class="widget">  
        <h4><?php echo $lang->company->contactUs;?></h4>
        <ul>
        <?php foreach($contact as $item => $value):?>
        <?php if($value == "") continue;?>
          <li><span><?php echo $lang->company->$item;?>:</span><?php echo $value;?></li>
        <?php endforeach;?>
        </ul>
      </div>
 
    </div>
  </div>

