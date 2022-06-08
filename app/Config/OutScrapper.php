<?php

namespace Config;

use CodeIgniter\Modules\Modules as BaseModules;

class OutScrapper extends BaseModules
{
   public $baseUrl = "https://api.app.outscraper.com";
   public $timeout = 20;
   public $apiKey = "YXV0aDB8NjBiNjQ4MjViNzhlZGUwMDY4NDg0NGVjfDk1NzIyMmNiNjM";

//Should be removed on production
   public $sampleId = "20220404130255ec65";
}
