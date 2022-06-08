<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Organizations extends BaseController
{
    public function index()
    {
        return view('organizations/index');
    }
}
