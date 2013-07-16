<?php include '../../common/view/header.admin.html.php';?>
<form target='hiddenwin' method='post'>
<table class='table-1' align='center'>
  <caption><?php echo $lang->help->export->title?></caption>
  <tr>
    <td>
      <p style='margin-top:50px;'>
        <p><span><?php echo $lang->help->export->account?></span><?php echo html::input('account', '')?></p>
        <span><?php echo $lang->help->export->lbl?></span>
        <select name='type'>
        <?php foreach($config->help->exportContent as $content):?>
        <option value='<?php echo $content?>'><?php echo $lang->tree->lists[$content]?></option>
        <?php endforeach?>
        </select>
        <?php echo html::submitButton()?>
      </p>
    </td>
  </tr>
</table>
</form>
<?php include '../../common/view/footer.admin.html.php';?>

