<?php
/**
 * The browse view file of block module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<table class="table table-bordered">
<caption>站点信息</caption> 
<tr>
  <th class="w-150px">
    站点名称：
  </th>
  <td>
    <input class='text-5' type='text'/>
  </td> 
</tr>
<tr>
  <th>
    站点口号：
  </th>
  <td>
    <?php echo html::input('name', '', 'class="text-1"');?>
  </td> 
</tr>
<tr>
  <th>
    站点描述：
  </th>
  <td>
  <?php echo html::textarea('desc', '', 'class="area-1"');?>
  </td> 
</tr>
</table>
<style>
.table th {text-align:right;vertical-align:middle;}
.table td {vertical-align:middle;}
.table td input{vertical-align:middle;margin:0;}
.table td textarea{vertical-align:middle;margin:0;}
</style>
<?php include '../../common/view/footer.admin.html.php';?>
