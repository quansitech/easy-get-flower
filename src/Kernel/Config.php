<?php


namespace EasyGetFlower\Kernel;


class Config
{

    public static $config = [];

    public static function setConfig(array $config){
        self::$config = $config;
    }

    public static function getConfig(){
        return self::$config;
    }

}