<?php include '../../../../common/view/header.html.php'; ?>
<?php include '../../../../common/view/treeview.html.php'; ?>

<div class='row'>
  <div class='u-1' id='banner'>
    <div class='row'>
      <div class='u-2-1'></div>
      <div class='u-2-1'>
        <h2 style='font-size:25px'><i><span class='strong'><?php printf($lang->saas->promotion->title, $app->site->name);?></span></i></h2>
        <ul class='f-16px' style='line-height:1.4'>
          <li>&raquo; <?php echo $lang->saas->promotion->function;?></li>
          <li>&raquo; <?php echo $lang->saas->promotion->price;?></li>
          <li>&raquo; <?php echo $lang->saas->promotion->maintain;?></li>
          <li>&raquo; <?php echo $lang->saas->promotion->speed;?></li>
          <li>&raquo; <?php echo $lang->saas->promotion->data;?></li>
          <li>&raquo; <?php echo $lang->saas->promotion->quit;?></li>
        </ul>
        <p class='a-center'>
        <?php if($app->site->code == '5upm') echo trim(html::a($this->createLink('pms', 'plans'), "<img src='$themeRoot" . "default/images/saas/try.big.gif' alt='{$lang->saas->alt->zentaopm}' />"));?>
        <?php if($app->site->code != '5upm') echo trim(html::a($this->createLink('pms', 'plans'), $lang->saas->promotion->try));?>
        </p>
      </div>
    </div>
  </div>
</div>
<div class='content'> <img src="<?php echo $themeRoot?>default/images/saas/function.png" alt="<?php echo $lang->saas->alt->function;?>" />
  <div class="f-right">
    <h2><?php echo $lang->saas->functions->caption;?></h2>
    <ul>
      <li><?php echo $lang->saas->functions->product;?></li>
      <li><?php echo $lang->saas->functions->schedule;?></li>
      <li><?php echo $lang->saas->functions->project;?></li>
      <li><?php echo $lang->saas->functions->document;?></li>
      <li><?php echo $lang->saas->functions->quality;?></li>
      <li><?php echo $lang->saas->functions->company;?></li>
    </ul>
  </div>
</div>
<div class='content'> <img src="<?php echo $themeRoot?>default/images/saas/why.png" alt="<?php echo $lang->saas->alt->reason;?>" />
  <div class="f-right">
    <h2><?php echo $lang->saas->why->caption;?></h2>
    <ul>
      <li><?php echo $lang->saas->why->function;?></li>
      <li><?php echo $lang->saas->why->openSource;?></li>
      <li><?php echo $lang->saas->why->concept;?></li>
      <li><?php echo $lang->saas->why->support;?></li>
      <li><?php echo $lang->saas->why->use;?></li>
      <li><?php echo $lang->saas->why->repo;?></li>
    </ul>
  </div>
</div>
<div class='content'> <img src="<?php echo $themeRoot?>default/images/saas/price.png" alt="<?php echo $lang->saas->alt->price;?>"/>
  <div class="f-right">
    <h2><?php echo $lang->saas->plans->caption;?></h2>
    <?php include '../../../../pms/view/blockplans.html.php';?>
  </div>
</div>
<div class='content'>
  <div class="half">
    <img src="<?php echo $themeRoot?>default/images/saas/case.png" alt="<?php echo $lang->saas->alt->case;?>" />
    <div class="f-right">
      <h2><?php echo $lang->saas->cases->caption;?></h2>
        <ul>
          <?php foreach($cases as $case):?>
          <li><?php printf($lang->saas->cases->list, $case->account, $case->openedDate)?></li>
          <?php endforeach;?>
        </ul>
    </div>
  </div>
  <div class="half">
    <img src="<?php echo $themeRoot?>default/images/saas/news.png" alt="<?php echo $lang->saas->news;?>" />
    <div class="f-right">
      <h2><?php echo $lang->saas->latestNews;?></h2>
      <dl>
        <?php foreach($articles as $article):?>
        <dt><?php echo html::a($this->createLink('article', 'view', "id=$article->id"), mb_strlen($article->title) > 19 ? mb_substr($article->title, 0, 17) . '...' : $article->title, '', "title='$article->title'")?></dt>
        <dd><?php echo date('Y-m-d', strtotime($article->addedDate))?></dd>
        <?php endforeach;?>
      </dl>
    </div>
  </div>
</div>
<div class="c-both"></div>
<?php include '../../../../common/view/footer.html.php'; ?>
