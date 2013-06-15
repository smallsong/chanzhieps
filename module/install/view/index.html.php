<?php
/**
 * The html template file of index method of install module of XiRangEPS.
 *
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     XiRangEPS
 * @version     $Id: index.html.php 867 2010-06-17 09:32:58Z wwccss $
 */
?>
<?php include './header.html.php';?>
<div class='container'>
  <div class='hero-unit'>
      <h2><?php echo $lang->install->welcome;?></h2>
 <p>     <?php echo nl2br(sprintf($lang->install->desc, $config->version));?></p>
      
        <?php if(!isset($latestRelease)):?>
        <p><?php echo html::a($this->createLink('install', 'step1'), $lang->install->start, '',  'class="btn btn-primary btn-large"');?></p>
        <?php else:?>
        <?php vprintf($lang->install->newReleased, $latestRelease);?>
        <p>
          <?php 
          echo $lang->install->choice;
          echo html::a($latestRelease->url, $lang->install->seeLatestRelease, '_blank');
          echo html::a($this->createLink('install', 'step1'), $lang->install->keepInstalling, 'class="btn btn-primary"');
          ?>
        </p>
        <?php endif;?>
  </div>
</div>
<?php include './footer.html.php';?>
