<?php

namespace App\Libraries\DeBounce;

use App\Helpers\ExcelHelper;
use Exception;
use GuzzleHttp\Client;

class Bouncer
{
    private Client $client;
    private $config;
    public function __construct()
    {
        $config = config('DeBounce');
        $this->client = new Client([
            'base_uri' => $config->baseUrl,
            'timeout'  => $config->timeout,
        ]);
        $this->config = $config;

    }

    public function verify($email)
    {
        $arrParams = [];
        $arrParams['api'] = $this->config->apiKey;
        $arrParams['email'] = $email;
        try {
            $url = "/v1/?". http_build_query($arrParams);
            $response = $this->client->get($url);
            $arrData = json_decode($response->getBody());
            return $arrData->debounce;
        } catch (Exception $ex) {
            return "";
        }
    }

    public static function create()
    {
        return new Bouncer();
    }
}
