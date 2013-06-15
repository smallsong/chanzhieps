    <div class='row'><div class='u-1'><?php if(isset($layouts)) $this->block->printBlock($layouts, 'footer');?></div></div>
  </div>
  <?php if(empty($_GET['onlybody']) or $_GET['onlybody'] != 'yes'):?>
  <div id='footer'>
    <div class='row'>
      <div class='u-1'>
        <div id='copyright' class='a-center f-left'>
        <?php 
        if($config->copyright->about) echo html::a($config->copyright->about, $lang->aboutus, '_blank') . " | ";
        list($name, $link) = explode('|', $lang->zentao->donation);
        echo html::a($this->createLink('partner'), $lang->zentao->partner) . ' | ';
        echo html::a($this->createLink('partner'), $lang->zentao->friendlyLinks) . ' | ';
        echo ' ' . html::a($link, $name);
        if($this->cookie->lang == 'zh-cn') echo ' | <span>4006-8899-23</span>';
        echo " | {$lang->zentao->linkCloud}";
        echo "<br />";
 
        echo '<a href="http://www.cnezsoft.com" target="_blank">&copy' . $lang->zentao->cnezsoft . '</a> ';
        echo $lang->icp . ' ';
        ?>
        </div>
        <div class='f-right' style='margin:30px 20px 0px 100px'><?php echo $lang->zentao->slogan;?></div>
      </div>
    </div>
    <div class='hidden'><?php if(isset($layouts)) $this->block->printBlock($layouts, 'end');?></div>
  </div>
  <?php endif;?>
  <div class='row'><div class='u-1'><iframe name='hiddenwin' id='hiddenwin' class='<?php $config->debug ? print('debugwin') : print('hidden');?>'></iframe></div></div>
</div>
<script laguage='Javascript'>
<?php $onlybody = (!empty($_GET['onlybody']) and $_GET['onlybody'] == 'yes') ? 'yes' : ''?>
var onlybody = '<?php echo $onlybody?>';
<?php if(isset($pageJS)) echo $pageJS;?>
</script>
</body>
</html>
