<?php


namespace EasyGetFlower\Client;

use EasyGetFlower\Kernel\BaseClient;
use EasyGetFlower\Kernel\Config;
use EasyGetFlower\Kernel\Helper;

class Link extends BaseClient
{

    protected $user;
    protected $bill;

    protected $xhh_num;
    protected $time_expire;

    protected $link_url = 'https://ssl.gongyi.qq.com/flower-integral/getFlowers.html';

    public function __construct(User $user, Bill $bill)
    {
        $this->user = $user;
        $this->bill = $bill;
        parent::__construct();
    }

    public function setXhhNum($xhh_num){
        $this->xhh_num = $xhh_num;
        return $this;
    }

    public function setTimeExpire($time_expire){
        $this->time_expire = $time_expire;
        return $this;
    }

    public function get(){
        list($is_bill_valid, $exchange_id) = $this->isBillValid();
        if (!$is_bill_valid){
            return false;
        }
        if (empty($exchange_id)){
            $exchange_id = $this->genExchangeId();
        }
        if ($exchange_id === false){
            return false;
        }

        return $this->buildLink($exchange_id);
    }

    protected function isBillValid(){
        $res = $this->bill->isExists();
        $exchange_id = $res['data']['exchange_id'];
        $xhh_code = $res['data']['xhh_code'];
        if (empty($exchange_id)){
            return [true, ''];
        }else if(empty($xhh_code)){
            return [true, $exchange_id];
        }else{
            return [false,''];
        }
    }

    protected function buildLink($exchange_id){
        $query = [
            'appid' => Config::get()['appid'],
            'timestamp' => time(),
            'nonce' => uniqid(),
            'trans_code' => $this->bill->getTransCode(),
            'exchange_id' => $exchange_id,
        ];

        $query['sign'] = Helper::genSign($query, Config::get()['key']);
        $query['et'] = Config::get()['et'];

        return $this->link_url.'?'.http_build_query($query);
    }

    protected function genExchangeId(){
        $user = $this->user->check();
        $can_user_get = (string)$user['code'] === '0' && empty($user['data']['attach']);
        if ($can_user_get){
            $res = $this->bill->preTry($this->xhh_num, $this->time_expire);
            return $res['data']['exchange_id'];
        }

        return false;
    }

}