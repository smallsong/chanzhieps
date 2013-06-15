<div id='commentbox'>
<?php if(isset($comments) and $comments):?>
<div class='cont'> 
  <div class='box-title '><?php echo $lang->comment->list;?></div>
  <div class='box-content' style='border:1px solid #ECECEC'>
    <?php foreach($comments as $number => $comment) :?>
      <div id='<?php echo $comment->id?>'  class='comment'>
      <strong>#<?php echo ($number + 1)?> <?php echo $comment->author;?></strong> at <?php echo $comment->date;?><br />
      <?php echo nl2br($comment->content);?>
    </div>
    <?php endforeach;?>
    <div id='pager'><?php $pager->show('right', 'sort');?></div>
    <div class='c-right'></div>
  </div>
</div>  
<?php endif;?>
<div class='cont'>
  <div class='box-title'><?php echo $lang->comment->post;?></div>
  <form method='post' target='hiddenwin' name='comment' action='<?php echo $this->createLink('comment', 'post');?>' class='box-content'>
    <table class='table-1 bd-none'>
      <tr>
        <td class='w-50px'><nobr><?php echo $lang->comment->author;?></nobr></td>
        <td> 
          <?php 
          $author = $this->session->user->account == 'guest' ? '' : $this->session->user->account;
          $email  = $this->session->user->account == 'guest' ? '' : $this->session->user->email;
          echo html::input('author', $author, "class='text-3'");
          ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $lang->comment->email;?></td>
        <td><?php echo html::input('email', $email, "class='text-3'");?></td>
      </tr>
      <tr>
        <td><?php echo $lang->comment->content;?></td>
        <td>
          <?php 
          echo html::textarea('content', '', "rows=5 class='area-1'");
          echo html::hidden('objectType', $objectType);
          echo html::hidden('objectID', $objectID);
          ?>
          <div id='yz'></div>
        </td>
      </tr>
      <tr><td></td><td><?php echo html::submitButton('', 'onclick="return checkGarbage(\'content\')"');?></td></tr>
    </table>
  </form>
  <div id='zbyz' class='hidden'><?php $this->comment->setVerify();?></div>
</div>
</div>
<script type='text/javascript'>
function checkGarbage(id)
{
  yzm     = $('#yzm').val();
  content = $('#' + id).val();
  $.post(createLink('comment', 'isGarbage'), {content:content, yzm:yzm}, function(data)
      {
          if(data == 1)
          {
            $('#yz').empty();
            $('#yz').html($('#zbyz').html() + '<br />');
          }
      });
}

$(function(){
    $('#pager a:first').attr('href', 'javascript:ajaxGetComment("<?php echo $this->createLink('comment', 'ajaxGetComment', "objectType=$objectType&objectID=$objectID&recTotal=$pager->recTotal&recPerPage=$pager->recPerPage&pageID=" . ($pager->pageID + 1))?>")');
    $('#pager a:last').attr('href', 'javascript:ajaxGetComment("<?php  echo $this->createLink('comment', 'ajaxGetComment', "objectType=$objectType&objectID=$objectID&recTotal=$pager->recTotal&recPerPage=$pager->recPerPage&pageID=$pager->pageTotal")?>")');
});

function ajaxGetComment(url)
{
    $.get(url,function(data){
        $('#commentbox .cont:first').find('.box-content').html(data);
    });
}
</script>
