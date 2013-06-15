<?php 
include '../../../view/header.lite.html.php';
if(empty($_GET['onlybody']) or $_GET['onlybody'] != 'yes'):
if($config->debug)
{
    js::import($jsRoot . 'jquery/superfish/superfish.js');
    css::import($themeRoot . 'default/superfish.css');
}
?>
<script language='javascript'>
$(document).ready(function()
{
    $('.sf-menu').superfish({delay:200})
});
</script>

<div class='row' id='topbar'>
  <div class='u-1 f-left'>
    <?php
    if($this->cookie->lang == 'zh-cn')
    {
      echo $lang->zentao->phone . '<span class="strong yellow"><span class="f-14px">4006-8899-23</span></span> ';
      echo '&nbsp;&nbsp;&nbsp;<span class="strong yellow">' . '<span class="f-14px">0532-8689 3032</span></span> ';
      echo '<strong>QQ: </strong>' . '<span class="strong yellow"><span class="f-14px">1492153927</span></span> ';
    }
    else
    {
        echo 'Email:' . ' <span class="strong yellow"><span class="f-14px">co@zentao.net</span></span>';
    }
    ?>
  </div>
  <div class='u-1 f-right'>
    <?php 
    $divider = '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;';
    if($this->cookie->lang == 'zh-cn') echo '<b>' . html::a('/', $lang->zentao->langs['zh-cn']) . '</b>' . $divider . html::a('/en/', $lang->zentao->langs['en']);
    if($this->cookie->lang == 'en')    echo html::a('/', $lang->zentao->langs['zh-cn']) . $divider . '<b>' . html::a('/en/', $lang->zentao->langs['en']) . '</b>';
    echo $divider;
    common::printTopBar();
    ?>
  </div>
</div>
<table class='table-1' id='header'>
  <tr valign='middle' class='a-center'>
    <td id='logobox' ><?php $config->features->logo ? print("<a href=http://{$app->site->domain}>" . html::image($app->site->fullLogoURL) . "</a>") : print($app->site->name);?></td>
    <td id='sloganbox'><h1><?php echo $app->site->slogan;?></h1></td>
    <td id='searchbox'><?php common::printSearch();?></td>
  </tr>
</table>
<div class='navbar'>
  <ul class='sf-menu'>
  <?php
  foreach($lang->zentao->menu as $key => $value)
  {
      echo '<li>';
      if(is_array($value))
      {
          list($name, $link, $target) = explode('|', array_shift($value));
          echo "<a href='$link' target='$target' id='menu$key'>$name</a>";
          echo '<ul>';
          foreach($value as $subMenu)
          {
              list($name, $link, $target) = explode('|', $subMenu);
              echo '<li>';
              echo "<a href='$link' target='$target'>$name</a>";
              echo '</li>';
          }
          echo '</ul>';
      }
      else
      {
          list($name, $link, $target) = explode('|', $value);
          echo "<a href='$link' target='$target'>$name</a>";
      }
      echo '</li>';
  }
  ?>
  </ul>
  <div class='c-left'></div>
</div>
<?php endif;?>
<div id='docbody'>
