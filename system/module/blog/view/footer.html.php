<?php
/**
 * The footer view file of blog category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
  <footer class="footer">
    <div class='a-center mb-20px'>
      <?php 
      echo "&copy; {$config->company->name} {$config->site->copyright}-" . date('Y') . '&nbsp;&nbsp;';
      echo $config->site->icp;
      printf($lang->poweredBy, $config->version, $config->version);
      echo html::a(helper::createLink('rss', 'index', '', 'xml') . '?type=blog', '<i class="icon icon-rss-sign icon-large"></i>', '_blank');
      ?>
    </div>
  </footer>
   
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);
?>
</div>
</body>
</html>
