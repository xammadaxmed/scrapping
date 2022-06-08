<?php

namespace App\Libraries\OutScrapper;

use App\Helpers\ExcelHelper;
use Exception;
use GuzzleHttp\Client;

class Scrapper
{
    private Client $client;
    private $config;
    private $excelTempsPath;
    public function __construct()
    {
        $config = config('OutScrapper');
        $appConfig = config('App');
        $this->client = new Client([
            'base_uri' => $config->baseUrl,
            'timeout'  => $config->timeout,
        ]);

        $this->excelTempsPath = $appConfig->ExcelTemps;
    }


    private function getRequiredHeaders()
    {
        return [
            'headers' => [
                'X-API-KEY' => 'YXV0aDB8NjBiNjQ4MjViNzhlZGUwMDY4NDg0NGVjfDk1NzIyMmNiNjM'
            ]
        ];
    }

    public function get($id)
    {
        try {
            $arrHeaders = $this->getRequiredHeaders();
            $response = $this->client->get("/tasks/$id", $arrHeaders);
            $arrData = json_decode($response->getBody());
            $filePath = $this->excelTempsPath . "/" . md5(time());
            if (!empty($arrData)) {
                if (@$arrData->status == "SUCCESS") {
                    $arrData = $arrData->results;
                    $fileUrl = $arrData[0]->file_url;
                    $fileContents = file_get_contents($fileUrl);
                    file_put_contents($filePath, $fileContents);
                }
            }
            return $filePath;
        } catch (Exception $ex) {
            return "";
        }
    }

    public static function create()
    {
        return new Scrapper();
    }
}
