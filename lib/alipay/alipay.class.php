<?php
class alipay
{
    public $config;

    /* 构造函数。*/
    public function __construct($config)
    {
        $this->initConfig($config);
    }

    /* 生成支付链接。*/
    public function createPayLink($orderNO, $subject, $money, $body = '', $extra = '')
    {
        /* 将这些参数设置到config对象中。*/
        $this->setConfig('orderNO', $orderNO);
        $this->setConfig('subject', $subject);
        $this->setConfig('money',   $money);
        $this->setConfig('body',    $body);
        $this->setConfig('extra',   $extra);

        /* 生成支付所需要的参数，并生成链接。*/
        $params = $this->createPayParams();
        $link = $this->config->payGW . http_build_query($params);
        return $link;
    }

    /* 初始化配置。*/
    private function initConfig($config)
    {
        $this->config = $config;
    }

    /* 设置某一个配置参数的值。*/
    private function setConfig($key, $value)
    {
        $this->config->$key = $value;
    }

    /* 生成支付需要的参数。*/
    private function createPayParams()
    {
        foreach($this->config->map as $ourKey => $aliKey)
        {
            if(isset($this->config->$ourKey) and $this->config->$ourKey and $ourKey != 'key') $params[$aliKey] = $this->config->$ourKey;
        }
        $params['sign'] = $this->createSign($params);
        return $params;
    }

    public function checkNotify($params)
    {
        if(!isset($params['notify_id']) or !isset($params['sign'])) return false;

        /* 检查是否通知信息是否真实有效。*/
        $noticeID = $params['notify_id'];
        $checkURL = $this->config->checkGW . "partner={$this->config->pid}&notify_id=$noticeID";
        $result = strtolower(trim(file_get_contents($checkURL)));
        if($result != 'true') return false;

        /* 签名检查。*/
        $mySign = $this->createSign($params);
        return $mySign == $params['sign'];
    }

    /* 生成签名。*/
    private function createSign($params)
    {
        /* 去掉不参与加密运算的元素。*/
        unset($params['sign_type']);
        unset($params['sign']);
        unset($params['key']);

        /* 按照键值进行排序。*/
        ksort($params);

        /* 拼接变量。需要调用一下urldeocde，估计支付宝那边是把参数decode之后进行签名的。*/
        $queryString = urldecode(http_build_query($params));
        $queryString .= $this->config->key;

        /* 加密。*/
        return md5($queryString);
    }
}
