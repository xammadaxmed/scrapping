<?php
namespace App\Libraries\Kendo;
use GuzzleHttp\Client;

class Scrapper
{

    public Client $guzzle;
    public $config;
    public function __construct()
    {
        $this->config = config("Kendo");
        $this->guzzle = new Client([
            'base_uri' => $this->config->baseUrl,
            'timeout' => $this->config->timeOut
        ]);
    }

    public static function init()
    {
        return new Scrapper();
    }

    public function search($domain)
    {
        return new Search($this, $domain);
    }
}
