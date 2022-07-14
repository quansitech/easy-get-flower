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

    public function __construct(array $config)
    {
        Config::set($config);
    }

    protected function setRes(Response $res):self{
        $this->res = $res;
        return $this;
    }

    public function getError():array{
        return $this->res instanceof Response ? $this->res->getRes() : [];
    }

    public function getUserXhhNum(string $openid){
        $res = (new User($openid))->totalNum();
        if ($res->getFlag() === true){
            return $res->getDataByKey('history_xhh');
        }else{
            $this->setRes($res);
            return false;
        }
    }

    public function hasBillUsed(string $openid, string $trans_code)
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

    public function buildLink(string $openid, string $trans_code, ?string $xhh_num, ?string $time_expire, string $jump_type = 'H5'){
        $user = new User($openid);
        $bill = new Bill($openid, $trans_code);

        $link = new Link($user, $bill);
        $xhh_num && $link->setXhhNum($xhh_num);
        $time_expire && $link->setTimeExpire($time_expire);
        $link->setJumpType($jump_type);

        $res = $link->get();
        if ($res instanceof Response){
            return $this->handleRes($res);
        }
        return $res;
    }

    protected function handleRes(Response $res){
        if ($res->getFlag() === true){
            return $res->getRes();
        }else{
            $this->setRes($res);
            return false;
        }
    }

}