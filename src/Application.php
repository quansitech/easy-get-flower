<?php

namespace EasyGetFlower;

use EasyGetFlower\Client\Bill;
use EasyGetFlower\Client\Link;
use EasyGetFlower\Client\User;
use EasyGetFlower\Kernel\Config;

class Application
{

    protected $config;

    public function __construct($config)
    {
        Config::setConfig($config);
    }

    public function getUserXhhNum($openid){
        return (new User($openid))->totalNum();
    }

    public function checkBill($openid, $trans_code){
        return (new Bill($openid, $trans_code))->isExists();
    }

    public function buildLink($openid, $trans_code, $xhh_num, $time_expire){
        $user = new User($openid);
        $bill = new Bill($openid, $trans_code);

        $link = new Link($user, $bill);
        $xhh_num && $link->setXhhNum($xhh_num);
        $time_expire && $link->setTimeExpire($time_expire);

        return $link->get();
    }

}