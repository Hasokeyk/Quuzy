<?php
	
	use Phpfastcache\Helper\Psr16Adapter;
	
	require "48186.php";
	require ROOT."/keyb/vendor/autoload.php";
	require ROOT."/keyb/functions.php";
	
	$username = 'home.decor.pin';
	$password = 'hasan.hayati@KODLA20';
	
	$instagram = new \InstagramScraper\Instagram();
	
	$kodlar = [
		'93760152',
		'16034928',
		'39680752',
		'81736902',
		'51783062',
	];
	
	if(!isset($_GET['test'])){
		header('Cache-Control: max-age=31536000');
		header('Content-Type: image/jpeg');
		header('Content-Disposition: inline; filename="'.$_GET['shortcode'].'.jpg"');
	}
	
	if(isset($_GET['shortcode']) and !empty($_GET['shortcode'])){
		
		$shortcode  = trim(strip_tags($_GET['shortcode']));
		$type       = trim(strip_tags($_GET['type']));
		
		if($type == 'user'){
			
			if(file_exists((__DIR__).'/cache/img/'.$shortcode)){
				$imageLink = (__DIR__).'/cache/img/'.$shortcode;
				echo file_get_contents($imageLink);
				exit;
			}else{
				$imageLink = $instagram->getAccount($shortcode)->getProfilePicUrl();
			}
			
		}else if($type == 'photo'){
			
			if(file_exists((__DIR__).'/cache/img/'.$shortcode)){
				$imageLink = (__DIR__).'/cache/img/'.$shortcode;
				echo file_get_contents($imageLink);
				exit;
			}else{
				try{
					$imageLink = $instagram->getMediaByCode($shortcode)->getImageThumbnailUrl();
				}catch(Exception $err){
					$imageLink = null;
				}
			}
			
		}else if($type == 'privatephoto'){
			
			if(file_exists((__DIR__).'/cache/img/'.$shortcode)){
				$imageLink = (__DIR__).'/cache/img/'.$shortcode;
				echo file_get_contents($imageLink);
				exit;
			}else{
				/*
				try{
					$instagram = \InstagramScraper\Instagram::withCredentials($instUsername, $instPassword, new Psr16Adapter('Files'));
					$instagram->login();
					$imageLink = $instagram->getMediaByCode($shortcode)->getImageThumbnailUrl();
				}catch(Exception $err){
					print_r($err->getTrace());
					exit();
				}
				*/
			}
			
		}
		
		$html = get_web_page($imageLink);
		if($html['http_code'] == 200){
			if(strlen($html['content']) > 100){
				$ac = fopen((__DIR__).'/cache/img/'.$shortcode,'w');
				fwrite($ac,$html['content']);
				fclose($ac);
				echo $html['content'];
			}
		}else{
			@unlink(ROOT.'/cache/img/'.$shortcode);
			echo file_get_contents(THEMEDIR.'/assets/img/default.jpg');
			exit;
		}
	
	}else{
		echo file_get_contents(THEMEDIR.'/assets/img/default.jpg');
	}