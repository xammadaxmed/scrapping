<?php
namespace App\Libraries\Kendo;

use Exception;
use GuzzleHttp\Client;

class Contact
{
    private  $payload;
    public function __construct($contacts)
    {
        $this->payload = $contacts;
    }
    public function first()
    {
       return !empty($this->payload)?$this->payload[0]:null;
    }


    public function last()
    {
        return !empty($this->payload)?end($this->payload):null;
    }

    public function all()
    {
        return $this->payload;
    }



}
