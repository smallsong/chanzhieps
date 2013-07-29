<?php
/**
 * The create view file of block category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
  <form method='post' class="form-horizontal"  id="ajaxForm"> 
    <!-- <h2><?php echo $lang->article->add;?></h2> -->
    <fieldset>
      <legend><?php echo $lang->article->add;?></legend>
      <div class="control-group">
        <label class="control-label" for="categories"><?php echo $lang->article->category;?></label>
        <div class="controls">
          <?php echo html::select("categories[]", $tree, $category ? $category->id : 0, '');?>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="author"><?php echo $lang->article->author;?></label>
        <div class="controls">
          <?php echo html::input('author', $app->user->realname, '');?>
        </div>
      </div>
      <div class="control-group">
        <label for="original" class="control-label"><?php echo $lang->article->original;?></label>
        <div class="controls">
          <?php
          echo html::select('original', $lang->article->originalList, 1, 'class=""');
          echo '&nbsp;' . $lang->article->copySite . html::input('copySite', '', 'class="span1"');
          echo '&nbsp;' . $lang->article->copyURL  . html::input('copyURL', '', 'class="span2"');
          ?>          
        </div>
      </div>
      <div class="control-group">
        <label for="title" class="control-label"><?php echo $lang->article->title;?></label>
        <div class="controls">
          <?php echo html::input('title', '', 'class="input-xxlarge"');?>   
        </div>
      </div>
      <div class="control-group">
        <label for="keywords" class="control-label"><?php echo $lang->article->keywords;?></label>
        <div class="controls">
          <?php echo html::input('keywords', '', 'class="input-xlarge"');?>   
        </div>
      </div>
      <div class="control-group">
        <label for="summary" class="control-label"><?php echo $lang->article->summary;?></label>
        <div class="controls">
          <?php echo html::textarea('summary', '', 'rows="5" class="span10"');?>
        </div>
      </div>
      <div class="control-group">
        <label for="content" class="control-label"><?php echo $lang->article->content;?></label>
        <div class="controls">
          <?php echo html::textarea('content', '', 'rows="5" class="span10"');?>
        </div>
      </div>
    </fieldset>
    <div class="form-actions">
      <?php 
        echo html::submitButton('','btn btn-primary btn-large');
      ?>
    </div>
  </form>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
