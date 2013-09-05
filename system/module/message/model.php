<?php
/**
 * The model file of message module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     message
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class messageModel extends model
{
    /**
     * Send message.
     * 
     * @param  string|array     $to 
     * @param  string           $message 
     * @param  string           $link 
     * @param  string           $from 
     * @access public
     * @return void
     */
    public function sendMessage($to, $message, $link = '', $from = 'system')
    {
        $data = new stdclass();
        $data->from    = $from;
        $data->content = mb_substr(strip_tags($message), 0, 50);
        $data->link    = 'http://' . $this->server->http_host . $link;
        $data->time    = helper::now();

        if(is_array($to))
        {
            foreach($to as $account)
            {
                if($account == $this->app->user->account) continue;
                $data->to = $account;
                $this->dao->insert(TABLE_MESSAGE)->data($data, false)->exec();
            }
        }
        else
        {
            if($to == $this->app->user->account) return;
            $data->to = $to;
            $this->dao->insert(TABLE_MESSAGE)->data($data, false)->exec();
        }
        return;
    }

    /**
     * Get messages of a user.
     * 
     * @param  string    $account 
     * @param  object    $pager 
     * @access public
     * @return array
     */
    public function getByAccount($account, $pager)
    {
        return $this->dao->select('*')->from(TABLE_MESSAGE)
            ->where('`to`')->eq($account)
            ->orderBy('id desc')
            ->page($pager, false)
            ->fetchAll('', false);
    }

    /**
     * Get message by id. 
     * 
     * @param  int    $id 
     * @access public
     * @return object
     */
    public function getByID($id)
    {
        return $this->dao->select('*')->from(TABLE_MESSAGE)->where('id')->eq($id)->fetch('', false);
    }

    /**
     * Mark the message readed.
     * 
     * @param  int    $id 
     * @access public
     * @return void
     */
    public function markReaded($id)
    {
        $this->dao->update(TABLE_MESSAGE)->set('readed')->eq(1)->where('id')->eq($id)->exec(false);
    }

    /**
     * Delete messages of a user..
     * 
     * @param  int     $message 
     * @param  string  $account 
     * @access public
     * @return void
     */
    public function deleteByAccount($message, $account)
    {
        $this->dao->delete()->from(TABLE_MESSAGE)->where('`to`')->eq($account)->andWhere('id')->eq($message)->exec(false);
    }
}
