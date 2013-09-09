<?php
/**
 * The view file of blog view method of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php 
include './header.html.php';
$path = array_keys($category->pathNames);
js::set('path',  json_encode($path));
js::set('articleID', $article->id);
include '../../common/view/treeview.html.php';
?>
<?php echo $common->printPositionBar($category);?>
<div class='row'>
  <div class='col-md-9'>
    <div class='content-box clearfix radius'>
      <div class='dater'><?php echo date('Y/m/d', strtotime($article->addedDate));?></div>
      <h1 class='text-center'><?php echo $article->title;?></h1>
      <div class='text-center info'>
        <?php
        printf($lang->article->lblAuthor,    $article->author);
        if($article->original)
        {
            echo "<strong>{$lang->article->originalList[$article->original]}</strong>";
        }
        else
        {
            printf($lang->article->lblSource);
            $article->copyURL ? print(html::a($article->copyURL, $article->copySite, '_blank')) : print($article->copySite); 
        }
        printf($lang->article->lblViews, $article->views);
        ?>
      </div>
      <p><?php echo $article->content;?></p>
      <div class='f-left'><?php $this->loadModel('file')->printFiles($article->files);?></div>
    </div>
    <div id='commentBox'></div>
    <?php echo html::a('', '', '', "name='comment'");?>
  </div>
  <?php include './side.html.php';?>
</div>
<?php include './footer.html.php';?>
