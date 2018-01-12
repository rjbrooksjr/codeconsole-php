<?php namespace rjbrooksjr;

use GuzzleHttp\Client;

class CodeConsole
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost',
            'timeout' => 2,
        ]);
    }

    public function log()
    {
        $params = json_encode(func_get_args());

        $this->client->post('api/log', [
            'form_params' => [
                'data' => $params,
            ]
        ]);
    }
}