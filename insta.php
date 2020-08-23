<?php
	
	require "48186.php";
	require KEYBDIR.'vendor/autoload.php';
	require KEYBDIR.'libs/instagram/EmailVerification.php';
	
	use Phpfastcache\Helper\Psr16Adapter;
	
	$username = 'home.decor.pin';
	$password = 'hasan.hayati@KODLA20';
	
	$yedekKodlar = [
		'09851234',
		'71254098',
		'72490638',
		'16593248',
		'41389065',
	];
	
	$instagram = \InstagramScraper\Instagram::withCredentials($username, $password, new Psr16Adapter('Files'));
	$instagram->setUserAgent('Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; 909) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537');
	$instagram->login(true); // will use cached session if you want to force login $instagram->login(true)
	$instagram->saveSession();  //DO NOT forget this in order to save the session, otherwise have no sense
	
	//$instagram = new \InstagramScraper\Instagram();
	echo $userID = $instagram->getAccount('hasokeyk')->getId();
	
	//$medias = $instagram->follow($userID);
	//$media = $account->getMedias();
	//print_r($medias);