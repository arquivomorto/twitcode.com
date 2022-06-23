<?php

$db=[
    'mysql'=>[
        'db'=>'twitcode',
        'host'=>'localhost',
        'user'=>'root',
        'password'=>'senha1234'
    ],
    'sqlite'=>[
        'file'=>__DIR__.'/db/db.sqlite3'
    ]
];
return [
    'db'=>$db,
    'dbDefault'=>'sqlite',
    'defaultLanguage'=>'en',
    'languages'=>'en,pt',    
    'root'=>__DIR__,
    'showErrors'=>true,
    'siteUrl'=>'http://localhost/twitcode.com'
];
