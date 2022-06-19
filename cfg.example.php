<?php
$db=[
	'mysql'=>[
		'db'=>'twitcode',
		'host'=>'localhost',
		'user'=>'root',
		'password'=>'senha1234'
	],
	'sqlite'=>[
		'file'=>__DIR__.'/dir/db.sqlite3'
	]
];
return [
	'showErrors'=>true,
	'db'=>$db
];