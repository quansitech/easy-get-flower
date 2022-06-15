<?php


namespace EasyGetFlower\Client;


use EasyGetFlower\Kernel\BaseClient;
use EasyGetFlower\Kernel\Response;

class User extends BaseClient
{
    protected $openid;

    public function __construct(string $openid)
    {
        $this->openid = $openid;
        parent::__construct();
    }

    public function check(?string $date, ?string $xhh_num):Response{
        $date =  $date ?: date('Ymd');
        $xhh_num = $xhh_num ?: 1;
        $params = [
            'open_id' => $this->openid,
            'trans_date' => $date,
            'xhh_num' => $xhh_num,
        ];

        return $this->postJson('CheckXhh', $params);
    }

    public function totalNum():Response{
        $params = [
            'open_id' => $this->openid,
        ];

        return $this->postJson('QueryUserXhh', $params);
    }

}