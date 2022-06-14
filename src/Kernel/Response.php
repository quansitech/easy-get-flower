<?php


namespace EasyGetFlower\Kernel;


class Response
{
    protected $flag;
    protected $res;

    public function __construct($res)
    {
        $this->res = $res;
        $this->handler($res);
    }

    protected function notError($res){
        $valid_code = ['30110502', '30130028'];

        return in_array($res['code'], $valid_code);
    }

    protected function isNormal($res){
        return (string)$res['code'] === '0';
    }

    protected function setFlag($flag){
        $this->flag = $flag;
        return $this;
    }

    public function getFlag(){
        return $this->flag;
    }

    public function getRes(){
        return $this->res;
    }

    public function getData(){
        return $this->res['data'];
    }

    public function getDataByKey($key){
        return $this->getData()[$key];
    }

    public function handler(array $res){
        if (self::isNormal($res)){
            $this->setFlag(true);
            return $this;
        }
        if (self::notError($res)){
            $this->setFlag(false);
            return $this;
        }

        E(json_encode($res));
    }

}