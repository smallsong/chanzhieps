<?php
/**
 * The admin view file of comment module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     comment
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php js::set('currentMenu', $status == 0 ? 0 : 1);?>
<table class='table table-bordered'>
  <caption><?php echo $lang->comment->statusList[$status] . $lang->comment->common;?></caption>
  <tbody>
    <tr>
      <th class='w-id'><?php echo $lang->comment->id;?></th>
      <th><?php echo $lang->comment->content;?></th>
      <th class='w-120px a-center'><?php echo $lang->actions;?></th>
    </tr>
    <?php foreach($comments as $comment):?>
    <tr>
      <td rowspan='2' class='a-center'><strong><?php echo $comment->id;?></strong></td>
      <td>
        <?php 
        $config->requestType = $config->frontRequestType;

        $objectViewURL = $this->createLink($comment->objectType, 'view', "id=$comment->objectID");
        if($comment->objectTitle != '')
        {
            $objectViewLink = html::a($objectViewURL, $comment->objectTitle, '_blank');
        }
        else
        {
            $objectViewLink = "<span class='alert-error'>{$lang->comment->deletedObject}</span>";
        }

        $config->requestType = 'GET';
        echo <<<EOT
        <strong>$comment->author</strong><i class='blue'>$comment->email</i> 
        <strong>$comment->date</strong>{$lang->comment->commentTo}
        $objectViewLink
EOT;
        ?>
      </td>
      <td rowspan='2' class='a-center v-middle'>
        <?php 
        echo html::a(inlink('delete', "commentID=$comment->id&type=single&status=$status"), $lang->comment->delete, '', "class='deleter'");
        if($status == 0) echo html::a(inlink('pass', "commentID=$comment->id&type=single"), $lang->comment->pass,   '', "class='pass'");
        echo html::a($objectViewURL . '#comment', $lang->comment->reply, '_blank');
        echo '<br />';
        if($status == 0) echo html::a(inlink('delete', "commentID=$comment->id&type=pre&status=$status"), $lang->comment->deletePre, '', "class='pre' data-confirm='{$lang->comment->confirmDeletePre}'");
        if($status == 0) echo html::a(inlink('pass',   "commentID=$comment->id&type=pre"), $lang->comment->passPre, '', "class='pre' data-confirm='{$lang->comment->confirmPassPre}'");
        ?>
      </td>
    </tr>
    <tr>
      <td class='content-box'><?php echo html::textarea('', $comment->content, "rows='2' class='area-1' spellcheck='false'");?></td>
    </tr>
    <?php endforeach;?>
  </tbody>
  <tfoot><tr><td colspan='3' class='a-right'><?php $pager->show();?></td></tr></tfoot>
</table>
<?php include '../../common/view/footer.admin.html.php';?>
