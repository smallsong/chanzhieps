<?php
/**
 * The xxx view file of xxx module of ZenTaoPMS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     xxx
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<form method='post' enctype='multipart/form-data' target='hiddenwin' action='<?php echo inlink('edit', "fileID=$file->id");?>'>
<table class='table-1' align='center'>
  <caption><?php echo $lang->file->edit;?></caption>
  <tr>
    <td><?php echo $lang->file->title;?></td> <td><?php echo html::input('title',$file->title);?></td>
  </tr>
    <tr>
    <td><?php echo $lang->file->pathname?></td> <td><?php echo $file->pathname; echo html::hidden('pathname',$file->pathname);?></td>
  </tr>
 <tr>
    <td><?php echo $lang->file->editFile;?></td> <td><?php echo html::file('upFile');?></td>
  </tr>
 <tr>
    <td><?php echo $lang->file->public?></td> <td><?php echo html::select('public', $lang->file->publics,$file->public);?></td>
  </tr>

</table>
<p align='center'><?php echo html::submitButton()?></p>
</form>
<?php include '../../common/view/footer.admin.html.php';?>

