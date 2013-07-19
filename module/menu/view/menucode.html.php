<div id="menuGrade1" class="hide">
  <li>
    <select>
      <option>导航类型</option>
    </select>
    <?php echo html::input('menu[1][title][]', '首页', 'class="input-small"');?> 
    <?php echo html::input('menu[1][url1][]', 'http://www.baidu.com', 'class="input"');?> 
    <?php echo html::hidden('menu[1][key][]', '', 'class="grade1key"');?> 
    <?php echo html::a('javascript:;', 'up', '', 'class="up"') ?>
    <?php echo html::a('javascript:;', 'down', '', 'class="down"') ?>
    <?php echo html::a('javascript:;', '收起子类', '', 'class="shut"' ) ?>
    <?php echo html::a('javascript:;', '展开子类', '', 'class="open"' ) ?>
    <?php echo html::a('javascript:;', '添加', '', 'class="plus1"' ) ?>
    <?php echo html::a('javascript:;', '添加子类', '', 'class="plus2"' ) ?>
    <?php echo html::a('javascript:;', '删除导航', '', 'class="remove"' ) ?>
</div>
<div id="menuGrade2" class="hide">
 <ul class="grade2">
  <li>
    <select>
        <option>导航类型</option>
    </select>
    <?php echo html::input('menu[2][title][]', '首页', 'class="input-small"');?> 
    <?php echo html::input('menu[2][url][]', 'http://www.baidu.com', 'class="input"');?> 
    <?php echo html::hidden('menu[2][parent][]', '', 'class="input-mini grade2parent"');?> 
    <?php echo html::hidden('menu[2][key][]', '', 'class="input-mini grade2key"');?> 
    <?php echo html::a('javascript:;', 'up', '', 'class="up"'); ?>
    <?php echo html::a('javascript:;', 'down', '', 'class="down"'); ?>
    <?php echo html::a('javascript:;', '收起子类', '', 'class="shut"'); ?>
    <?php echo html::a('javascript:;', '展开子类', '', 'class="open"'); ?>
    <?php echo html::a('javascript:;', '添加', '', 'class="plus2"'); ?>
    <?php echo html::a('javascript:;', '添加子类', '', 'class="plus3"'); ?>
    <?php echo html::a('javascript:;', '删除导航', '', 'class="remove"'); ?>
    </li>
  </ul>
</div>
<div id="menuGrade3" class="hide">
  <ul class="grade3">
    <li>
    <select>
        <option>导航类型</option>
    </select>
    <?php echo html::input('menu[3][title][]', '首页', 'class="input-small"');?> 
    <?php echo html::input('menu[3][url][]', 'http://www.baidu.com', 'class="input"');?> 
    <?php echo html::hidden('menu[3][parent][]', '', 'class="input-mini grade3parent"');?> 
    <?php echo html::a('javascript:;', 'up', '', 'class="up"') ?>
    <?php echo html::a('javascript:;', 'down', '', 'class="down"') ?>
    <?php echo html::a('javascript:;', '收起子类', '', 'class="shut"' ) ?>
    <?php echo html::a('javascript:;', '展开子类', '', 'class="open"' ) ?>
    <?php echo html::a('javascript:;', '添加', '', 'class="plus3"' ) ?>
    <?php echo html::a('javascript:;', '删除导航', '', 'class="remove"' ) ?>
    </li>
  </ul>
</div>

