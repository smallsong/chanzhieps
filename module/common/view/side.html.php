<?php
$contact= json_decode($this->config->company->contact);
$topCategories = $this->loadModel('tree')->getChildren(0);
?>
<div class='span3'>
  <div class='widget radius'> 
    <h4><?php echo $lang->categoryMenu;?></h4>
    <ul>
      <?php foreach($topCategories as $topCategory):?>
      <li>
        <?php
        $browseLink = $this->createLink('article', 'browse', "categoryID={$topCategory->id}");
        echo '<i class="icon-chevron-right"></i> ';
        echo html::a($browseLink, $topCategory->name, '', "id='category{$topCategory->id}'");
        ?>
      </li>
      <?php endforeach;?>
    </ul>
  </div>

  <div class='widget radius'>  
    <h4><?php echo $lang->company->contactUs;?></h4>
    <ul>
      <?php 
      foreach($contact as $item => $value)
      {
          if($value == "") continue;
          echo "<li><span>{$lang->company->$item}</span>$value</li>";
      }
      ?>
    </ul>
  </div>
</div>
