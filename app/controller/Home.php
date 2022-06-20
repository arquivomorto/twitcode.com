<?php

namespace app\controller;

use app\mix\Utils;

class Home extends Utils
{
    public function index()
    {
        $data=['title'=>'Twitcode'];
        parent::view('home', $data);
    }
}
