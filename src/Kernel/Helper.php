<?php


namespace EasyGetFlower\Kernel;


class Helper
{

    public static function genSign($params, $key){
        ksort($params);

        $params['key'] = $key;

        return strtoupper(hash_hmac('sha256', http_build_query($params), $key));
    }

}