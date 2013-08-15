<?php
/**
 * The model file of company of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     company 
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class companyModel extends model
{
    /**
     * get contact information.
     * 
     * @access public
     * @return string
     */
    public function getContact()
    {
        $contact = json_decode($this->config->company->contact);
        foreach($contact as $item => $value)
        {
            if($value)
            {
                if($item == 'qq') 
                {
                    $contact->qq = html::a("tencent://message/?uin={$value}&amp;Site={$this->config->company->name}&amp;Menu=yes", $value);
                }
                else if($item == 'email')
                {
                    $contact->email = html::a("mailto:{$value}", $value);
                }
                else if($item == 'wangwang')
                {
                    $contact->wangwang = html::a("http://www.taobao.com/webww/ww.php?ver=3&touid={$value}&siteid=cntaobao&status=2&charset=utf-8", $value);
                }
            }
            else
            {
                unset($contact->$item);
            }
        }
        return $contact;
    }
}
