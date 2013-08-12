<?php
js::set('objectType', $objectType);
js::set('objectID',   $objectID);
css::internal($pageCSS);
?>
<?php
if(isset($comments) and $comments):?>
<div id='commentList' class='commentList radius-top'> 
  <div class='box-title'><?php echo $lang->comment->list;?></div>
  <div class='box-content'>
    <a name='first'></a>
    <?php foreach($comments as $number => $comment):?>
      <div id='<?php echo $comment->id?>' class='comment'>
        <strong>#<?php echo ($number + 1)?><?php echo $comment->author;?></strong> at <?php echo $comment->date;?><br />
        <?php echo nl2br($comment->content);?>
      </div>
    <?php endforeach;?>
    <div id='pager'><?php $pager->show('right', 'shortest');?></div>
    <div class='c-right'></div>
  </div>
</div>  
<?php endif;?>
<div class='cont'>
  <form method='post' id='commentForm' action="<?php echo $this->createLink('comment', 'post');?>" class='form-inline'>
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
          echo html::textarea('content', '', "rows='3' class='area-1'");
          echo html::hidden('objectType', $objectType);
          echo html::hidden('objectID', $objectID);
          ?>
        </td>
      </tr>
      <tr id='captchaBox' style="display:none;"></tr>  
      <tr><td></td><td><?php echo html::submitButton();?></td></tr>
    </table>
  </form>
</div>
<?php js::execute($pageJS);?>
