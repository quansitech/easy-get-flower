<?php

namespace EasyGetFlower\Kernel;

use GuzzleHttp\Client;

trait HttpMethod
{
    protected $client;

    public function __construct(){
        $this->client = new Client(['base_uri' => $this->getBaseUri()]);
    }

    public function postJson(string $uri, array $params = []){
        return $this->postBase($uri, $this->getHeader(), $params, 'json');
    }

    public function post(string $uri, array $params = [])
    {
        return $this->postBase($uri, $this->getHeader(), $params);
    }

    protected function postBase(string $uri, array $headers = [], array $params = [], string $param_type = 'x-www-form-urlencoded')
    {
        $options = [
            'headers' => $headers
        ];

        if ($param_type === 'x-www-form-urlencoded') {
            $options['form_params'] = $params;
        }

        if ($param_type === 'json') {
            $options['json'] = $params;
        }

        $response = $this->client->request('POST', $uri, $this->getOptions($options));
        return new Response(json_decode($response->getBody()->getContents(), true));
    }

    abstract public function getBaseUri();
    abstract public function getHeader();

    protected function getOptions($options){
        $def = ['http_errors' => false];
        return array_merge($options, $def);
    }

}