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
        $options = [
            'headers' => $this->getHeader(),
            'json' => $params
        ];

        $response = $this->client->request('POST', $uri, $options);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function post(string $uri, array $params = [])
    {
        $options = [
            'headers' => $this->getHeader(),
            'form_params' => $params
        ];

        $response = $this->client->request('POST', $uri, $options);

        return json_decode($response->getBody()->getContents(), true);
    }

    abstract public function getBaseUri();
    abstract public function getHeader();

}