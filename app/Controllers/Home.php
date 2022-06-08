<?php

namespace App\Controllers;

use App\Helpers\TableHelper;
use App\Libraries\OutScrapper\Scrapper;
use App\Models\Configuration;
use CodeIgniter\Database\Migration;

class Home extends BaseController
{
    public function index()
    {
        return view('index');
    }

    
}

