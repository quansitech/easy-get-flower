<?php

namespace EasyGetFlower\Kernel;

class BaseClient
{
    use \EasyGetFlower\Kernel\HttpMethod;

    public function getBaseUri(){
        return 'https://oapi.gongyi.qq.com/api/xhh_third_service/';
    }

    public function getHeader(){
        $header = [
            'Gy-H-Api-Appid' => Config::getConfig()['appid'],
            'Gy-H-Api-Timestamp' => time(),
            'Gy-H-Api-Nonce-Str' => uniqid()
        ];

        $header['Gy-H-Api-Sign'] = Helper::genSign($header,Config::getConfig()['key']);

        return $header;
    }

}