<?php
/**
 * The model file of help module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Yidong wang <wangyidong@cnezsoft.com>
 * @package     help
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class helpModel extends model
{
    /**
     * getOrderId 
     * 
     * @param  string    $book 
     * @param  string    $moduleID 
     * @param  id        $parentID 
     * @access public
     * @return void
     * @todo rewrite the logic.
     */
    public function getOrderId($book, $moduleID, $parentID = '')
    {
        $allModules = $this->dao->select('*')->from(TABLE_MODULE)
            ->where('tree')->eq($book)
            ->beginIF($parentID !='')->andWhere('parent')->eq($parentID)->fi()
            ->orderBy('grade, `order`')->fetchAll('id');
        $order = 1;
        foreach($allModules as $thisModule)
        {
            if($moduleID == $thisModule->id)break;
            $order++;
        }
        return $order;
    }

    /**
     * Get donors 
     * 
     * @access public
     * @return array
     */
    public function getDonors()
    {
        return $this->dao->select('*')->from(TABLE_DONATION)->where('status')->eq('paid')->orderBy('id desc')->fetchAll('id', false);
    }

    public function saveOrder()
    {
        $data = fixer::input('post')
            ->add('createdDate', helper::now())
            ->add('account', $this->app->user->account)
            ->add('status', 'wait')
            ->setDefault('name', 'guest')
            ->get();
        $this->dao->insert(TABLE_DONATION)->data($data, false)->check('money', 'notempty')->exec();
        if(!dao::isError()) return $this->dao->lastInsertID();
        return false;
    }

    public function getOrderByRawID($rawOrder)
    {
        $order = $this->dao->select('*')->from(TABLE_DONATION)->where('id')->eq((int)$rawOrder)->fetch('', false);
        $order->subject = $this->lang->help->donation;
        if(!$order) return false;
        $this->loadModel('alipay');
        $order->humanOrder = $this->alipay->getHumanOrder($order->id);
        return $order;
    }

    public function processOrder($orderID)
    {
        /* Get order and site. */
        $order = $this->getOrderByRawID($orderID);

        $result = $this->loadModel('alipay')->processOrder($order, 'donation');
        if($result == 'success' and $order->status == 'wait' and $order->account != 'guest')
        {
            return $this->dao->update(TABLE_USER)->set('love = love + ' . $order->money)->where('account')->eq($order->account)->exec();
        }
        else
        {
            return $result;
        }
    }

    /**
     * Get the prev and next ariticle.
     * 
     * @param  array  $links    the link articles.
     * @param  int    $current  the current article id.
     * @access public
     * @return array
     */
    public function getPrevAndNext($links, $current)
    {
        $prev = array();
        $next = array();
        $keys = array_keys($links);

        $currentKey = array_search($current, $keys);
        $prevKey    = $currentKey - 1;
        $nextKey    = $currentKey + 1;

        if(isset($keys[$prevKey])) $prev = array('id' => $keys[$prevKey], 'title' => $links[$keys[$prevKey]]);
        if(isset($keys[$nextKey])) $next = array('id' => $keys[$nextKey], 'title' => $links[$keys[$nextKey]]);

        return array('prev' => $prev, 'next' => $next);
    }
}
