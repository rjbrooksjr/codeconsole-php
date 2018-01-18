<?php namespace rjbrooksjr;

use GuzzleHttp\Client;
use Psr\Log\LogLevel;

class CodeConsole
{
    private static $client = null;
    private static $apiKey;

    static public function setApiKey($key) 
    {
        self::$apiKey = $key;
    }

    static public function log($level = LogLevel::INFO, $message, array $context = [])
    {
        self::send($level, $message, $context);
    }

    static public function error($message, array $context = [])
    {
        self::send(LogLevel::ERROR, $message, $context);
    }

    static private function send($level, $message, $context)
    {
        if (empty(self::$apiKey)) {
            throw new \Exception('Missing API Key');
        }

        if (self::$client === null)
        {
            self::$client = new Client([
                'base_uri' => 'http://localhost',
                'timeout' => 2,
            ]);
        }

        array_unshift($context, $message);

        self::$client->post('api/log', [
            'form_params' => [
                'key' => self::$apiKey,
                'type' => $level,
                'data' => $context,
            ]
        ]);
    }
}