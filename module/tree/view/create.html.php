<?php
/**
 * The create view of product module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     product
 * @version     $Id: create.html.php 824 2010-05-02 15:32:06Z wwccss $
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.html.php';?>
<div id='doc3'>
  <form method='post'>
    <table align='center' class='table-4'> 
      <caption><?php echo $lang->product->create;?></caption>
      <tr>
        <th class='rowhead'><?php echo $lang->product->name;?></th>
        <td class='a-left'><input type='text' name='name' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->product->code;?></th>
        <td class='a-left'><input type='text' name='code' /></td>
      </tr>  
      <tr>
        <th class='rowhead'><?php echo $lang->product->desc;?></th>
        <td class='a-left'><textarea name='desc' style='width:100%' rows='5'></textarea></td>
      </tr>  
      <tr>
        <td colspan='2'>
          <input type='submit' value='<?php echo $lang->product->saveButton;?>' accesskey='S' />
          <input type='reset'  value='<?php echo $lang->reset;?>' />
        </td>
      </tr>
    </table>
  </form>
</div>  
<?php include '../../common/view/footer.html.php';?>
