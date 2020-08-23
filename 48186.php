<?php 

    global $mysqli,$pinBot;

    setlocale(LC_ALL, 'turkish'); 
	
	//ISTANBUL SAATİNE GÖRE ZAMANI AYARLAR
	date_default_timezone_set('Asia/Baghdad');
	ini_set( 'date.timezone', 'Asia/Baghdad' );
		
	//PHP HATALARINI EKRANDA GÖSTERİR
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

    //VERİTABANI
    $mysqli = new mysqli('localhost','quuzydb','48186hasokeyk','quuzydb');
    if($mysqli->connect_error){
        echo 'hata';
        exit;
    }else{
        $mysqli->set_charset("utf8mb4");
    }
    //VERİTABANI

    define('ROOT',(__DIR__));
    define('KEYBDIR',ROOT.'/keyb/');
    define('THEMENAME','quuzy');
    define('THEMEDIR',ROOT.'/themes/'.THEMENAME.'/');
    define('THEMEPATH','https://quuzy.com/themes/'.THEMENAME.'/');
    define('SITENAME','https://quuzy.com');