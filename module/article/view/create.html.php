<?php
/**
 * The create view file of article category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
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
  <table class='table table-form'>
    <caption><?php echo $lang->article->create;?></caption>
    <tr>
      <th class='w-100px'><?php echo $lang->article->category;?></th>
      <td><?php echo html::select("categories[]", $categories, $currentCategory, "multiple='multiple' class='select-3 chosen'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->article->author;?></th>
      <td><?php echo html::input('author', $app->user->realname, "class='text-3'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->article->original;?></th>
      <td>
        <?php echo html::select('original', $lang->article->originalList, 1, "class='select-3'");?>
        <span id='copyBox'>
          <?php
          echo html::input('copySite', '', "class='text-2' placeholder='{$lang->article->copySite}'");
          echo html::input('copyURL',  '', "class='text-4' placeholder='{$lang->article->copyURL}'");
          ?>
        </span>
      </td>
    </tr>
    <tr>
      <th><?php echo $lang->article->title;?></th>
      <td><?php echo html::input('title', '', "class='text-1'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->article->keywords;?></th>
      <td><?php echo html::input('keywords', '', "class='text-1'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->article->summary;?></th>
      <td><?php echo html::textarea('summary', '', "rows='2' class='area-1'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->article->content;?></th>
      <td valign='middle'><?php echo html::textarea('content', '', "rows='10' class='area-1'");?></td>
    </tr>
    <tr>
      <td></td>
      <td><?php echo html::submitButton() . html::hidden('type', $type);?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>
