<?php include '../../../../common/view/header.html.php'; ?>
<?php include '../../../../common/view/treeview.html.php'; ?>
<!--[if IE 6]> 
<style> 
.banner1 {height:270px}
#products {float:left; padding-bottom:10px} 
</style>
<![endif]-->

<div class='row'>
  <div class='u-1' id='banner'>
    <?php 
    for($i = 1; $i <= $this->config->zentao->bannerNum; $i++)
    {
        $currentBanner = "banner$i";
        if($i == 1)
        {
            echo "<div class='banner$i'>";
        }
        else
        {
            echo "<div class='banner$i' style='display:none'>";
        }
        echo "<div class='f-left'><ul>";
        echo "<li class='first-child'>{$lang->index->$currentBanner->title}</li>";
        echo "<li>{$lang->index->$currentBanner->list1}</li>";
        echo "<li>{$lang->index->$currentBanner->list2}</li>";
        echo "<li>{$lang->index->$currentBanner->list3}</li>";
        echo "<li>{$lang->index->osDownLink}{$lang->index->proDownLink}</li>";
        echo "</ul></div>";
        echo "<div class='banner_pic' id='banner{$i}_pic'></div></div>";
    }
    ?>
  </div>
  <div id='banner_nav' class='a-right'>
    <a id='banner1' onmouseover='changeBanner(1)' onclick='changeBanner(1)' class='banner-select'>&nbsp;</a>
    <a id='banner2' onmouseover='changeBanner(2)' onclick='changeBanner(2)'>&nbsp;</a>
    <a id='banner3' onmouseover='changeBanner(3)' onclick='changeBanner(3)'>&nbsp;</a>
    <a id='banner4' onmouseover='changeBanner(4)' onclick='changeBanner(4)'>&nbsp;</a>
    <a id='banner5' onmouseover='changeBanner(5)' onclick='changeBanner(5)'>&nbsp;</a>
  </div>
</div>

<div>
  <div class='u-1'>
    <div id='what'>
      <div class='f-left'><span>WHAT / </span><?php echo $lang->index->productsAndServices;?></div>
      <div class='f-right'><span id='icon-telephone'>&nbsp;</span>4006-8899-23&nbsp;&nbsp;&nbsp;<span id='icon-qq'>&nbsp;</span>co@zentao.net(1492153927)</div>
    </div>
  </div>
  <div class='divider'></div>
  <div class='divider'></div>
  <div>   
     <div class='u-3-2' id='products'>
       <div class='product f-left' id='product1'>
         <table class='table-1'>
           <tr><th><a  href='<?php echo $lang->index->community->titleLink; ?>'><?php echo $lang->index->community->title; ?></a></th></tr>
           <tr><td><div class='divider'></div></td></tr>
           <tr><td><?php echo $lang->index->community->list1;?></td></tr>
           <tr><td><?php echo $lang->index->community->list2;?></td></tr>
           <tr><td><?php echo $lang->index->community->list3;?></td></tr>
           <tr><td><?php echo $lang->index->community->list4;?></td></tr>
           <tr><td><div class='divider'></div></td></tr>
           <tr>
             <td>
             <div class='f-left'><input type='button' value='<?php echo $lang->index->freeDownload; ?>' onclick="location.href='<?php echo $lang->index->community->buttonLink?>'"/></div>
             <div class='f-right'><a href='<?php echo $lang->index->community->moreLink?>'>more . . .</a></div>
             </td>
           </tr>
         </table>
       </div>
       <div class='product f-left' id='product2'>
         <div id='icon-pro'></div>
         <table class='table-1'>
           <tr><th><a href='<?php echo $lang->index->pro->titleLink;?>'><?php echo $lang->index->pro->title; ?></a></th></tr>
           <tr><td><div class='divider'></div></td></tr>
           <tr><td><?php echo $lang->index->pro->list1;?></td></tr>
           <tr><td><?php echo $lang->index->pro->list2;?></td></tr>
           <tr><td><?php echo $lang->index->pro->list3;?></td></tr>
           <tr><td><?php echo $lang->index->pro->list4;?></td></tr>
           <tr><td><div class='divider'></div></td></tr>
           <tr>
             <td>
             <div class='f-left'><input type='button' value='<?php echo $lang->index->freeTry; ?>' onclick="location.href='<?php echo $lang->index->pro->buttonLink;?>'"/></div>
             <div class='f-right'><a href='<?php echo $lang->index->pro->moreLink;?>'>more . . .</a></div>
             </td>
           </tr>
         </table>
       </div>
       <div class='product f-left' id='product3'>
         <table class='table-1'>
           <tr><th><a href='<?php echo $lang->index->zentaocs->titleLink;?>'><?php echo $lang->index->zentaocs->title; ?></a></th></tr>
           <tr><td><div class='divider'></div></td></tr>
           <tr><td><?php echo $lang->index->zentaocs->list1;?></td></tr>
           <tr><td><?php echo $lang->index->zentaocs->list2;?></td></tr>
           <tr><td><?php echo $lang->index->zentaocs->list3;?></td></tr>
           <tr><td><?php echo $lang->index->zentaocs->list4;?><td></tr>
           <tr><td><div class='divider'></div></td></tr>
           <tr><td><div class='f-left'><input type='button' value='<?php echo $lang->index->freeTry; ?>' onclick="location.href='<?php echo $lang->index->zentaocs->buttonLink;?>'"/></div></td></tr>
         </table>
       </div>
       <div class='product f-left' id='product4'>
         <table class='table-1'>
           <tr><th><a href='<?php echo $lang->index->zentaoPHP->titleLink;?>'><?php echo $lang->index->zentaoPHP->title; ?></a></th></tr>
           <tr><td><div class='divider'></div></td></tr>
           <tr><td><?php echo $lang->index->zentaoPHP->list1;?><td></tr>
           <tr><td><?php echo $lang->index->zentaoPHP->list2;?></td></tr>
           <tr><td><?php echo $lang->index->zentaoPHP->list3;?></td></tr>
           <tr><td><?php echo $lang->index->zentaoPHP->list4;?></td></tr>
           <tr><td><div class='divider'></div></td></tr>
           <tr>
             <td>
               <div class='f-left'><input type='button' value='<?php echo $lang->index->download;?>' onclick="location.href='<?php echo $lang->index->zentaoPHP->buttonLink;?>'"/></div>
               <div class='f-right'><a href='<?php echo $lang->index->zentaoPHP->moreLink;?>'>more . . .</a></div>
             </td>
           </tr>
         </table>
       </div>
     </div>
     <div class='u-3-1' id='services'>
     <?php
     for($i = 1; $i <= 4; $i++)
     {
       $currentServer = "server$i";
       $color = $i == 1 ? "style='color:red'" : '';
       if(!$lang->index->$currentServer->title) continue;
       echo "<div class='server' id='$currentServer'>";
       echo "<div class='item'><span id='{$lang->index->$currentServer->icon}'>&nbsp;</span><a href='{$lang->index->$currentServer->url}' $color>{$lang->index->$currentServer->title}</a></div>";
       echo "<div class='desc'>{$lang->index->$currentServer->desc}</div>";
       echo "</div>";
     }
     ?>
     </div>
  </div>   
</div>
<div class='divider'></div>

<div id='otherItems'>
  <div style='float:left;'>
    <table>
      <tr class='a-center first-child'>
        <td><a id='icon-openPlatform' href='http://www.xirang.biz/open-index.html'>&nbsp;</a></td>
        <td><a id='icon-help' href='http://www.xirang.biz/ask-faq.html'>&nbsp;</a></td>
        <td><a id='icon-feedback' href='http://www.xirang.biz/forum-board-1074.html'>&nbsp;</a></td>
        <td><a id='icon-chinascrum' href='http://www.chinascrum.org'>&nbsp;</a></td>
        <td><a id='icon-agileabc' href='http://www.agileabc.org'>&nbsp;</a></td>
      </tr>
      <tr class='a-center a-top' style='font-size:14px'>
        <td><a href='http://www.xirang.biz/open-index.html'><?php echo $lang->index->openPlatform;?></a></td>
        <td><a href='http://www.xirang.biz/ask-faq.html'><?php echo $lang->index->help;?></a></td>
        <td><a href='http://www.xirang.biz/forum-board-1074.html'><?php echo $lang->index->feedback;?></a></td>
        <td><a href='http://www.chinascrum.org'><?php echo $lang->index->chinascrum;?></a></td>
        <td><a href='http://www.agileabc.org'><?php echo $lang->index->agileabc;?></a></td>
      </tr>
    </table>
  </div>
  <span onclick="location.href='http://www.xirang.biz/thread-view-81355.html'">
  <a id='ad' class='f-right' href='http://www.xirang.biz/article-view-79801.html' target='_blank'></a>
  </span>
</div>
<div class='divider'></div>

<div style='height:300px;'>
  <div class='u-3-2 f-left' id='usercase'>
    <div id='who'><span>WHO / </span><?php echo $lang->index->userCases;?></div>
    <div class='divider'></div>
    <div class='box-content'>
      <table>
      <?php
      foreach($lang->index->caseCategories as $category => $name)
      {
          echo "<tr><th>$name</th>";
          foreach($lang->index->caseLinks[$category] as $key => $url) echo "<td><a href='$url' id='" . $category . $key ."'>&nbsp;</a></td>";
          echo "</tr>";
      }
      ?>
      </table>
      <div class='c-both'></div>
    </div>
  </div>
  <div class='u-3-1 f-right' id='news'>
    <div id='newsHeader'><span>NEWS / </span><?php echo $lang->index->dynamic;?></div>
    <div class='divider'></div>
    <div class='box-content'>
      <dl>
        <?php $i = 1;?>
        <?php foreach($articles as $article):?>
        <?php if($i > $this->config->zentao->limitNum ) break;?>
        <dt>
        <?php 
        $title = $article->title;
        if(mb_strlen($article->title) >= 14 and  $this->cookie->lang == 'zh-cn') $title = mb_substr($article->title, 0, 15) . '...';
        if(mb_strlen($article->title) >= 30 and  $this->cookie->lang == 'en')    $title = substr($article->title, 0, 31) . '...';
        echo html::a($this->createLink('article', 'view', "id=$article->id"), $title, '', "title='$article->title'");
        ?>
        <div class='f-right'><?php echo substr($article->addedDate, 5, 5); ?></div>
        </dt>
        <?php $i++;?>
        <?php endforeach;?> 
      <div>
        <span class='f-right'>
        <?php $this->cookie->lang == 'zh-cn' ? print html::a($this->createLink('article', 'browse', "moduleID=1072"), 'more') : print html::a($this->createLink('article', 'browse', "moduleID=1279"), 'more');?>
        </span>
      </div>
      </dl>
      <div class='c-both'></div>
    </div>
  </div>
</div>
<script>
$(function(){ timer = setInterval("autoBanner()", 5000);})

function autoBanner()
{
    if($(document).scrollTop() < 500)
    {
        bannerNum  = $("#banner_nav a").length;
        bannerName = $("#banner_nav a[class='banner-select']").attr("id");

        for(i = 1; i <= bannerNum; i++)
        {
            if(bannerName.indexOf(i) > 0)
            {
                nextBanner = i == bannerNum ? 1 : i+1;
                $("#banner_nav #banner" + i).attr("class", " ");
                $("#banner_nav #banner" + nextBanner).attr("class", "banner-select");
                $("#banner .banner" + i).hide();
                $("#banner .banner" + nextBanner).fadeIn();
            }
        }
    }
}

var changing = false;
function changeBanner(index) 
{
    if(changing == false)
    {
        changing = true;
        clearInterval(timer);
        bannerNum = $("#banner_nav a").length;
        $("#banner_nav #banner" + index).css('top', '-5px');
        for(i = 1; i <= bannerNum; i++)
        {
            if(index != i) 
            {
                $("#banner div[class='banner" + i +"']").hide();
                $("#banner_nav #banner" + i).css('top', '0px');
            }
        }
        $("#banner .banner" + index).fadeIn('slow', function(){changing = false});
    }
}
</script>
<?php include '../../../../common/view/footer.html.php'; ?>
