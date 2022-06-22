<?php

namespace app\controller;

use app\lib\Utils;

class HomeController extends Utils
{
    public function index()
    {
        $data=['title'=>'Twitcode'];
        parent::view('home', $data);
    }
}
