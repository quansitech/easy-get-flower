<?php

namespace EasyGetFlower;

use EasyGetFlower\Client\Bill;
use EasyGetFlower\Client\Link;
use EasyGetFlower\Client\User;
use EasyGetFlower\Kernel\Config;
use EasyGetFlower\Kernel\Response;

class Application
{

    protected $res;

    public function __construct($config)
    {
        Config::set($config);
    }

    protected function setRes($res){
        $this->res = $res;
        return $this;
    }

    public function getError(){
        return $this->res->getRes();
    }

    public function getUserXhhNum($openid){
        $res = (new User($openid))->totalNum();
        if ($res->getFlag() === true){
            return $res->getDataByKey('history_xhh');
        }else{
            $this->setRes($res);
            return false;
        }
    }

    public function hasBillUsed($openid, $trans_code)
    {
        $bill = new Bill($openid, $trans_code);
        $res = $bill->isExists();
        if ($res->getFlag() === true) {
            $has_used = !empty($res->getDataByKey('xhh_code'));
            return (int)$has_used;
        } else {
            $this->setRes($res);
            return false;
        }
    }

    public function buildLink($openid, $trans_code, $xhh_num, $time_expire){
        $user = new User($openid);
        $bill = new Bill($openid, $trans_code);

        $link = new Link($user, $bill);
        $xhh_num && $link->setXhhNum($xhh_num);
        $time_expire && $link->setTimeExpire($time_expire);

        $res = $link->get();
        if ($res instanceof Response){
            return $this->handleRes($res);
        }
        return $res;
    }

    protected function handleRes($res){
        if ($res->getFlag() === true){
            return $res->getRes();
        }else{
            $this->setRes($res);
            return false;
        }
    }

}