<div id="menuGrade1" class="hide">
  <li>
    <?php echo $this->menu->inputTags(1);?>
  </li>
</div>
<div id="menuGrade2" class="hide">
  <ul class="grade2">
    <li><?php echo $this->menu->inputTags(2);?></li>
  </ul>
</div>
<div id="menuGrade3" class="hide">
  <ul class="grade3">
    <li><?php echo $this->menu->inputTags(3);?></li>
  </ul>
</div>
<div id="articleSelector" class="hide">
  <?php echo $this->menu->articleSelector('grade');?>
</div>
<div id="commonSelector" class="hide">
  <?php echo $this->menu->commonmenuSelector('grade');?>
</div>
