<?php


namespace EasyGetFlower\Kernel;


class Config
{

    public static $config = [];

    public static function set(array $config){
        self::checkRequired($config, ['appid', 'key', 'et']);
        self::$config = $config;
    }

    public static function get(){
        return self::$config;
    }

    protected static function checkRequired($config,$keys){
        foreach($keys as $key){
            if (empty($config[$key])){
                E("缺少配置值".$key);
            }
        }
    }

}