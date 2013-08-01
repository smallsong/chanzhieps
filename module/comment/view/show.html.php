<?php
js::set('thisUri',$thisUri);
if(isset($comments) and $comments):?>
<div id="commentList" class='commentList radius-top'> 
  <div class="box-title"><?php echo $lang->comment->list;?></div>
  <div class='box-content'>
    <a name="first"></a>
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
  <form method='post' id='commentForm' action='<?php echo $this->createLink('comment', 'post');?>' class='form-inline'>
    <table class='table table-form'>
      <caption><?php echo $lang->comment->post;?></caption>
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
        </td>
      </tr>
      <tr id="checkCode" style="display:none;"></tr>  
      <tr><td colspan="2"><?php echo html::submitButton();?></td></tr>
    </table>
  </form>
</div>
<style>
.commentList {border:1px solid #DDDDDD; padding: 0; margin-bottom:20px; }
.comment { border: 1px solid #DDDDDD; margin: 10px 5px 5px; padding: 5px;}
.box-title {margin:0;padding:0 0 0 8px; line-height:34px; height:34px; font-weight:bold; border: 0; }
.page {margin-right:10px;padding:8px; font-size:13px;}
</style>
<script type='text/javascript'>
$(document).ready(function()
{
    $('#content').change(function()
    {
        $.post(createLink('comment', 'captcha'), {content:$(this).val()}, function(data)
        {
            $('#checkCode').html(data).fadeIn();
        });

    });

    $.setAjaxForm('#commentForm', function(data)
    {
        if(data.result=='success' && $.type(data.message) != 'object')
        {
            bootbox.alert(data.message, function()
            {
                    $('#commentForm').parent().parent().load(v.thisUri,location.href="#first");
            });   
        }
        else
        {
            bootbox.alert(data.message.notice, function()
            {
                $('#checkCode').load(createLink('comment', 'checkCode')).show();
            });
        }
    });
    
    $('#pager').find('a').click(function()
    {
        $('#commentList').parent().load($(this).attr('href'));
        return false;
    });
});
</script>
