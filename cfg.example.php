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
$email=[
    // https://nilhcem.github.io/FakeSMTP/downloads/fakeSMTP-latest.zip
    // java -jar fakeSMTP-2.0.jar -p 2525
    'test'=>[
        'name'=>'Twitcode',
        'from'=>'noreply@twitcode.com',        
        'auth'=>false,
        'type'=>'smtp',
        'host'=>'localhost',
        'port'=>'2525',
        'user'=>'',
        'password'=>'',
    ]
];
return [
    'db'=>$db,
    'dbDefault'=>'sqlite',
    'defaultLanguage'=>'en',
    'email'=>$email,
    'emailDefault'=>'test',
    'languages'=>'en,pt',    
    'root'=>__DIR__,
    'showErrors'=>true,
    'siteUrl'=>'http://localhost/twitcode.com'
];
