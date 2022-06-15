<?php


namespace EasyGetFlower\Client;


use EasyGetFlower\Kernel\BaseClient;
use EasyGetFlower\Kernel\Response;

class Bill extends BaseClient
{
    protected $openid;
    protected $trans_code;

    public function __construct(string $openid, string $trans_code)
    {
        $this->openid = $openid;
        $this->trans_code = $trans_code;
        parent::__construct();
    }

    public function preTry(string $xhh_num, ?string $time_expire):Response{
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

    public function isExists():Response{
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