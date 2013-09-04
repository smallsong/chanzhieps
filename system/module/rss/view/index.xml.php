<?php
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<rss version="2.0">
<channel>
  <title><?php echo $title;?></title>
  <link><?php echo $siteLink;?></link>
  <description><?php echo $app->site->mission;?></description>
  <copyright><?php echo $config->copyright->start . '-' . date('Y');?></copyright>
  <lastBuildDate><?php echo $lastDate;?></lastBuildDate>
  
  <?php 
  foreach($articles as $article):
    $category = current($article->categories);
  ?>
  <item>
    <title><?php echo $article->title?></title>
    <description><![CDATA[  <?php echo $article->content;?>]]></description>
    <link><?php echo $siteLink . $this->createLink('article', 'view', "id=$article->id", 'html');?></link>
    <category><?php echo $category->name; ?></category>
    <pubDate><?php echo $article->addedDate . ' +0800';?></pubDate>
  </item>
  <?php endforeach;?>
</channel>
</rss>
