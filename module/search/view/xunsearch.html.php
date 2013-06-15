<?php include '../../common/view/header.html.php'; ?>
<?php $common->printPositionBar($module, '', $keywords);?>
<div class='row'>
  <div id="search-results" class='u-24-19'>
    <ol>
    <?php 
    foreach($results as $result)
    {
        echo '<li>' . html::a($result->url, $result->title, '_blank') . "<div id='url'>$result->url</div><p>" . $result->content . "</p></li>";
    }
    ?>
    </ol>
    <div id='pager'><?php $pager->show($align = 'left');?>
      <div class='a-right'>Powered by <a href='http://www.xunsearch.com' target='_blank'>xunSearch</a></div>
    </div>
  </div>
  <div class='u-24-5 f-right'>
    <div class='u-1'>
    <?php
    if($relatedWords and $results)
    {
        echo "<div id='keywords'><span>". $keywords . "</span>的相关搜索</div>";
        foreach($relatedWords as $words)
        {
            echo '<div>' . html::a($this->inLink('xunSearch', "moduleName=$moduleName") . "?key=$words", $words) . '</div>';
        }
    }
    ?>
   </div>
   <div class='u-1'>
   <?php
    if($hotWords and $results)
    {
        echo "<div id='hotWords'>热门搜索词</div>";
        foreach($hotWords as $words => $times)
        {
            echo '<div>' . html::a($this->inLink('xunSearch', "moduleName=$moduleName") . "?key=$words", $words) . '</div>';
        }
    }
    ?>
    </div>
  </div> 
</div>
<?php include '../../common/view/footer.html.php'; ?>
<script>
if($('.u-24-19').height() < $('.u-24-5').height())
{
    $('.u-24-19').height($('.u-24-5').height());
}
</script>
