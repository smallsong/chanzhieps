<?php if(isset($comments) and $comments):?>
<div style='font-size:21px; font-weight:bold; margin-bottom:10px;'><?php echo $lang->comment->list;?></div>
<table class='table'>
  <?php foreach($comments as $number => $comment) :?>
  <tr>
    <td>
      <strong>#<?php echo ($number + 1)?> <?php echo $comment->author;?></strong> at <?php echo $comment->date;?><br />
      <?php echo nl2br($comment->content);?>
    </td>
  </tr>
  <?php endforeach;?>
  <tr><td><?php $pager->show('right', 'sort');?></td></tr>
</table>
<?php endif;?>

<form class='form-horizontal' method='post' target='hiddenwin' name='comment' action='<?php echo $this->createLink('comment', 'post');?>'>
  <fieldset>
    <legend><?php echo $lang->comment->post;?></legend>

    <div class="control-group">
      <label class="control-label" for="inputIcon"><?php echo $lang->comment->author;?></label>
      <div class="controls">
        <div class="input-prepend">
          <span class="add-on"><i class="icon-user"></i></span>
          <input class="span2" id="inputIcon" type="text" name='author'>
        </div>
      </div>
    </div>
 
    <div class="control-group">
      <label class="control-label" for="inputIcon"><?php echo $lang->comment->email;?></label>
      <div class="controls">
        <div class="input-prepend">
          <span class="add-on"><i class="icon-envelope"></i></span>
          <input class="span2" id="inputIcon" type="text" name='email'>
        </div>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="inputIcon"><?php echo $lang->comment->content;?></label>
      <div class="controls">
          <?php 
          echo html::textarea('content', '', "rows=3 class='area-1'");
          echo html::hidden('objectType', $objectType);
          echo html::hidden('objectID', $objectID);
          ?>
      </div>
    </div>


    <div class="control-group">
      <div class="controls">
        <button type="submit" class="btn btn-primary" onclick="return checkGarbage('content')"><?php echo $lang->save;?></button>
      </div>
    </div>

  </fieldset>
</form>
<div id='zbyz' class='hidden'><?php $this->comment->setVerify();?></div>

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
