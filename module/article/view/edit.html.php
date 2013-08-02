<?php
/**
 * The edit view file of article module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/chosen.html.php';?>
<form method='post' class='form-inline' id='ajaxForm'>
  <table class='table table-bordered table-form'>
    <caption><?php echo $lang->article->edit;?></caption>
    <tr>
      <th class='w-100px'><?php echo $lang->article->category;?></th>
      <td>
        <?php echo html::select("categories[]", $categories, array_keys($article->categories), "multiple='multiple' class=select-3 ");?>
      </td> 
    </tr> 
    <tr>
      <th><?php echo $lang->article->author;?></th>
      <td><?php echo html::input('author', $article->author, 'class=text-3');?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->article->original;?></th>
      <td>
        <?php echo html::select('original', $lang->article->originalList, $article->original, 'class=select-3');?>
        <span id='copyBox'>
          <?php
          echo html::input('copySite', $article->copySite, "class='text-2' placeholder='{$lang->article->copySite }'");
          echo html::input('copyURL', $article->copyURL, "class='text-3' placeholder='{$lang->article->copyURL}'");
          ?>
        </span>
      </td>
    </tr>
    <tr>
      <th><?php echo $lang->article->title;?></th>
      <td><?php echo html::input('title', $article->title, 'class=text-1');?></td>
    </tr>
   <tr>
      <th><?php echo $lang->article->keywords;?></th>
      <td><?php echo html::input('keywords', $article->keywords, 'class=text-1');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->article->summary;?></th>
      <td><?php echo html::textarea('summary', $arricle->summary, "rows='2' class='area-1'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->article->content;?></th>
      <td><?php echo html::textarea('content', htmlspecialchars($article->content), 'rows=25 class=area-1');?></td>
    </tr>
    <tr>
      <th></th>
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
