<?php include '../../common/view/header.html.php'; ?>
<div class='row'>
  <div class='u-1'>
    <h1 class='a-center'><?php echo $lang->help->title;?></h1>
    <table class='table-1 f-14px'>
      <caption class='caption-tl'><?php echo $lang->$module->common;?></caption>
        <tr class='colhead'>
        <th class='w-id'><?php echo $lang->help->id;?></th>
        <th class='w-100px'><?php echo $lang->help->field;?></th>
        <th><?php echo $lang->help->explaination;?></th>  
       </tr>
       <?php
       unset($lang->$module->common);
       if(strpos('bug|story|task|testcase', $module) !== false)
       {
           $lang->$module->comment = $lang->help->comment;
           $lang->$module->labels  = $lang->help->labels;
       }
       $i = 1;
       foreach($lang->$module as $key => $fieldDesc)
       {
           list($fieldName, $fieldNote) = explode('|', $fieldDesc);
           $class = $field == $key ? 'backblue' : '';
           echo "<tr id='$key' class='$class'>
                  <th class='$class'>$i</th>
                  <th class='a-left'>$fieldName</th>
                  <td>$fieldNote</td>
                </tr>";
            $i ++;
       }
       ?>
    </table>
  </div>
</div>  
<?php include '../../common/view/footer.html.php';?>
