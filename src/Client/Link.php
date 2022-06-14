<?php


namespace EasyGetFlower\Client;

use EasyGetFlower\Kernel\BaseClient;
use EasyGetFlower\Kernel\Config;
use EasyGetFlower\Kernel\Helper;
use EasyGetFlower\Kernel\Response;

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
        $bill_res = $this->bill->isExists();
        if ($bill_res->getFlag() === false){
            return $bill_res;
        }

        list($is_bill_valid, $exchange_id) = $this->isBillValid($bill_res);
        if (!$is_bill_valid){
            return new Response(['code' => 'qs_custom', 'msg' => '无法领取，订单已失效']);
        }
        if (empty($exchange_id)){
            $exchange_id = $this->genExchangeId();
        }
        if ($exchange_id instanceof Response){
            return $exchange_id;
        }
        if ($exchange_id === false){
            return new Response(['code' => 'qs_custom', 'msg' => '无法领取，用户已达领取上限']);
        }

        return $this->buildLink($exchange_id);
    }

    protected function isBillValid($bill_res){
        $exchange_id = $bill_res->getDataByKey('exchange_id');
        $xhh_code = $bill_res->getDataByKey('xhh_code');
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
        if ($user->getFlag() === false){
            return $user;
        }
        $can_user_get = (string)$user->getRes()['code'] === '0' && empty($user->getDataByKey('attach'));
        if ($can_user_get){
            $bill_res = $this->bill->preTry($this->xhh_num, $this->time_expire);
            if ($bill_res->getFlag() === false){
                return $bill_res;
            }else{
                return $bill_res->getDataByKey('exchange_id');
            }
        }

        return false;
    }

}