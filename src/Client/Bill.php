<?php


namespace EasyGetFlower\Client;


use EasyGetFlower\Kernel\BaseClient;

class Bill extends BaseClient
{
    protected $openid;
    protected $trans_code;

    public function __construct($openid, $trans_code)
    {
        $this->openid = $openid;
        $this->trans_code = $trans_code;
        parent::__construct();
    }

    public function preTry($xhh_num, $time_expire = null){
        $time_expire = $time_expire ?: date('Y-m-d H:i:s', strtotime("+10 mins"));
        $params = [
            'open_id' => $this->openid,
            'trans_code' => $this->trans_code,
            'time_start' => date('Y-m-d H:i:s'),
            'time_expire' => $time_expire,
            'xhh_num' => $xhh_num
        ];

        return $this->postJson('PreTry', $params);
    }

    public function isExists(){
        $params = [
            'open_id' => $this->openid,
            'trans_code' => $this->trans_code,
        ];

        return $this->postJson('CheckIsTransExist', $params);
    }

    public function getTransCode(){
        return $this->trans_code;
    }
}