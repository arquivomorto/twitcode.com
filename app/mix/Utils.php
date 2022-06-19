<?php
namespace app\mix;

class Utils{
	function cfg(){
		$filename=realpath(__DIR__.'/../../cfg.php');
		if(file_exists($filename)){
			$arr=require $filename;
			return $arr;
		}else{
			die('cp cfg.example.php cfg.php');
		}
	}
	function showErrors($bool){
		if($bool){
			ini_set('display_errors',1);
			ini_set('display_startup_errors',1);
			error_reporting(E_ALL);
		}else{
			ini_set('display_errors',0);
			ini_set('display_startup_errors',0);
			error_reporting(0);
		}
	}
}