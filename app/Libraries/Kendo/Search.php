<?php
namespace App\Libraries\Kendo;
use Exception;
use GuzzleHttp\Client;

class Search
{

    private Scrapper $scrapper;
    private  $domain;
    private $config;

    public function __construct(Scrapper $_scrapper, $domain)
    {
        $this->scrapper = $_scrapper;
        $this->domain = $domain;
        $this->config = $_scrapper->config;
    }

    public function postJson($strURI)
    {
        try {
            $response = $this->scrapper->guzzle->request('GET', $strURI, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]);
            return json_decode($response->getBody());
        } catch (Exception $ex) {
           
        }
    }

    public function contacts($category = "", $type = "", $maxresults = "10")
    {
        $arrBody = [
            'apikey' => $this->config->apiKey,
            'domain' => $this->domain,
            'maxresults' => $maxresults,
            'keywords' => $category,
            'type' => $type
        ];
        $strUrl = "/companyleads?". http_build_query($arrBody);
        $response = $this->postJson($strUrl);
        return new Contact($response);
    }

    public function company()
    {
        $arrBody = [
            'apikey' => $this->config->apiKey,
            'domain' => $this->domain
        ];
        $strUrl = "/companybydomain?". http_build_query($arrBody);
        $response = $this->postJson($strUrl);
        return $response;
    }

    public function async()
    {

        $arrBody = [
            'apikey' => $this->config->apiKey,
            'domain' => $this->domain
        ];
        $strUrl = "/companybydomain?". http_build_query($arrBody);
       
        
        try {
           $promise =  $this->scrapper->guzzle->requestAsync('GET',$strUrl,[
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
                ])->then(function($response){
                    echo($response->getBody());
                });
                return $promise;
        } catch (Exception $ex) {
           dd($ex->getMessage());
        }

    }

}
