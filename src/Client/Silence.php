<?php


namespace EasyGetFlower\Client;

use EasyGetFlower\Kernel\BaseClient;
use EasyGetFlower\Kernel\Config;

class Silence extends BaseClient
{

    public function __construct()
    {
        parent::__construct();
    }

    public function buildSilenceWechatStatusLink():array{

        $query = [
            'business_id' => Config::get()['et']
        ];

        return [
            'link' => 'pages/flower-integral/index/main'.'?'.http_build_query($query),
        ];

    }

}