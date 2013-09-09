<?php
/**
 * The admin view file of comment module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     comment
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php js::set('currentMenu', $currentMenu);?>
<table class='table table-bordered'>
  <caption>
    <ul class="nav nav-tabs" id="statusNav">
      <li <?php if(0==$status) echo "class='active'";?>>
        <?php echo html::a($this->inLink('admin', "status=0"), $lang->comment->statusList[0]);?>
      </li>
      <li <?php if(1==$status) echo "class='active'";?>>
        <?php echo html::a($this->inLink('admin', "status=1"), $lang->comment->statusList[1]);?>
      </li>
    </ul>
  </caption>
  <thead>
    <tr>
      <th class='w-60px'><?php echo $lang->comment->id;?></th>
      <th><?php echo $lang->comment->content;?></th>
      <th class='w-140px a-center'><?php echo $lang->actions;?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($comments as $comment):?>
    <tr>
      <td rowspan='2' class='a-center'><strong><?php echo $comment->id;?></strong></td>
      <td>
        <?php 
        $config->requestType = $config->frontRequestType;

        if($comment->objectTitle != '')
        {
            $objectViewLink = html::a($comment->objectViewURL, $comment->objectTitle, '_blank');
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
        echo html::a($comment->objectViewURL . '#comment', $lang->comment->reply, '_blank');
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
