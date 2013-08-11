<form id="slideForm" method='post' class="form-inline" enctype='multipart/form-data' action='<?php echo inlink('create');?>'>
  <table class='table table-bordered'>
    <caption><?php echo $lang->slide->create;?></caption>
    <tr>
      <th class="w-100px"><?php echo $lang->slide->title;?></th>
      <td><?php echo html::input('title', '', 'class=text-1');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->slide->url;?></th>
      <td><?php echo html::input('url', '', 'class=text-1');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->slide->image;?></th>
      <td><?php echo html::file('files[]', "tabindex='-1'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->slide->label;?></th>
      <td><?php echo html::input('label', '', 'class=text-1');?></td>
    </tr>
    <tr>
      <th><?php echo $lang->slide->summary;?></th>
      <td><?php echo html::textarea('summary', '', 'class=area-1');?></td>
    </tr>
    <tr><td colspan='2' class='a-center'><?php echo html::submitButton();?></td></tr>
  </table>
</form>
<?php js::execute($pageJS);?>
