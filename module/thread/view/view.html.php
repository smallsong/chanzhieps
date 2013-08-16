<?php
/**
 * The view file of thread module of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
include '../../common/view/header.html.php';
include '../../common/view/kindeditor.html.php';

$common->printPositionBar($board, $thread);

include './thread.html.php';
include './reply.html.php';

include '../../common/view/footer.html.php';
