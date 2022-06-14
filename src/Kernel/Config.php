<?php


namespace EasyGetFlower\Kernel;


class Config
{

    public static $config = [];

    public static function set(array $config){
        self::$config = $config;
    }

    public static function get(){
        return self::$config;
    }

}