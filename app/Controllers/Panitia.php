<?php

namespace App\Controllers;

class Panitia extends BaseController
{
    public function index(): string
    {
        $data['title'] = 'Dashboard Panitia';
        return view('panitia/index', $data);
    }
}