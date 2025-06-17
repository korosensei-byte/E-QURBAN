<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // return view('welcome_message');
        return view('auth/login');

    }

    // coba2
    public function register(){
        return view('auth/register'); 

    }
    // coba3
    public function user(){
        return view('user/index');

    }
}
