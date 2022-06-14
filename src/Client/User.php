<?php


namespace EasyGetFlower\Client;


use EasyGetFlower\Kernel\BaseClient;

class User extends BaseClient
{
    protected $openid;

    public function __construct($openid)
    {
        $this->openid = $openid;
        parent::__construct();
    }

    public function check($date = '', $xhh_num = 0){
        $date =  $date ?: date('Ymd');
        $xhh_num = $xhh_num ?: 1;
        $params = [
            'open_id' => $this->openid,
            'trans_date' => $date,
            'xhh_num' => $xhh_num,
        ];

        return $this->postJson('CheckXhh', $params);
    }

    public function totalNum(){
        $params = [
            'open_id' => $this->openid,
        ];

        return $this->postJson('QueryUserXhh', $params);
    }

}