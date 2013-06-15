<?php
/**
 * The html template file of download method of file module of XiRangEPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     XiRangEPS
 * @version     $Id$
 */
include '../../../../common/view/header.lite.html.php';
?>
<div class='row' style='margin-top:100px'>
  <div class='u-6-1'></div>
  <div class='u-3-2'>
  <?php echo $this->fetch('score', 'noscore', array('method' => 'download', 'score' => $score));?>
  </div>
  <div class='u-6-1'></div>
</div>
</body>
</html>
