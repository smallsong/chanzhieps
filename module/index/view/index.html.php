<?php include '../../common/view/header.html.php'; ?>
<?php include '../../common/view/treeview.html.php'; ?>
<?php $LatestArticles =  articleModel::getLatestArticle(0,8);
      $contact        = json_decode($this->config->company->contact);
?>
<div class="hero-unit radius">
<?php echo $this->config->site->desc; ?>
</div>
<div class="row-fluid">
  <div class="span4">
    <h2><?php echo $lang->index->aboutus;?></h2>
    <p><?php echo $this->config->company->desc;?></p>
    <p><?php echo html::a($this->createLink('company', 'index'), '更多', '', "class='btn btn-info'");?></p>
  </div>
  <div class="span4">
    <h2><?php echo $lang->index->news;?></h2>
    <?php foreach($LatestArticles as $id => $article): ?>
      <p><?php echo html::a($this->createLink('article','view', "id=$id"), $article, '', "class='latest-news'");?></p>
    <?php endforeach; ?>
  </div>
  <div class="span4">
    <h2><?php echo $lang->index->contact;?></h2>
    <?php foreach($contact as $item => $value):?>
    <?php if($value == "") continue;?>
    <p><strong><?php echo $lang->company->$item;?>:</strong><?php echo $value;?></p>
    <?php endforeach;?>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>
