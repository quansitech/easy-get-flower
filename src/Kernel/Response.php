<?php


namespace EasyGetFlower\Kernel;


class Response
{
    protected $flag;
    protected $res;

    public function __construct(array $res)
    {
        $this->res = $res;
        $this->handler($res);
    }

    protected function notError(array $res){
        $valid_code = ['qs_custom', '30110502', '30130028'];

        return in_array($res['code'], $valid_code);
    }

    protected function isNormal(array $res){
        return (string)$res['code'] === '0';
    }

    protected function setFlag(bool $flag){
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

    public function getDataByKey(string $key){
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