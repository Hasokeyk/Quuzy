<?php

	require "48186.php";
	require ROOT."/keyb/vendor/autoload.php";
	require ROOT."/keyb/functions.php";

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
				$file = (__DIR__).'/cache/img/'.$shortcode;
				$last_modified_time = filemtime($file);
				$etag = md5_file($file);

				header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT");
				header("Etag: $etag");
				header('Content-Length: ' . filesize($file));
				$img = readfile((__DIR__).'/cache/img/'.$shortcode);
			}else{
				$insLink = "https://instagram.com/".$shortcode."/?__a=1";
				$html = get_web_page($insLink);

				if(isset($_GET['test'])){
					print_r($html);
					exit;
				}

				if($html['http_code'] == 200){
					$imageLink = json_decode($html['content']);
					$imageLink = $imageLink->graphql->user->profile_pic_url_hd;
					//$imageLink = $imageLink->data->user->reel->user->profile_pic_url;
				}else{
					echo file_get_contents(THEMEDIR.'/assets/img/default.jpg');
					exit;
				}
			}

		}else if($type == 'photo'){

			if(file_exists((__DIR__).'/cache/img/'.$shortcode)){
				$file = (__DIR__).'/cache/img/'.$shortcode;
				$last_modified_time = filemtime($file);
				$etag = md5_file($file);

				header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT");
				header("Etag: $etag");
				header('Content-Length: ' . filesize($file));
				$img = readfile((__DIR__).'/cache/img/'.$shortcode);
			}else{
				$insLink = "https://instagram.com/p/".$shortcode."/?__a=1";
				$html = get_web_page($insLink);
				if(isset($_GET['test'])){
					print_r($html);
					exit;
				}
				if($html['http_code'] == 200){
					if(!stristr($html['content'],'<!DOCTYPE html>')){
						$imageLink = json_decode($html['content']);
						$imageLink = $imageLink->graphql->shortcode_media->display_url;
					}else{
						$mysqli->query("DELETE FROM userposts WHERE shortcode = '".$shortcode."'");
						@unlink(ROOT.'/cache/img/'.$shortcode);
						exit;
					}
				}else if($html['http_code'] == 404){

					$ask = $mysqli->query("SELECT * FROM userposts WHERE shortcode = '".$shortcode."'");
					if($ask->num_rows > 0){
						$user = $ask->fetch_assoc();
						$htmlName = md5('/instagram/'.$user['username'].'/').'.html';
						@unlink(ROOT.'/cache/html/'.$htmlName);
						@unlink(ROOT.'/cache/html/'.md5('/').'.html');

						$mysqli->query("DELETE FROM userposts WHERE shortcode = '".$shortcode."'");
					}
					echo file_get_contents(THEMEDIR.'/assets/img/default.jpg');
					exit;
				}else{
					echo file_get_contents(THEMEDIR.'/assets/img/default.jpg');
					exit;
				}
			}

		}else{
			echo file_get_contents(THEMEDIR.'/assets/img/default.jpg');
			exit;
		}

		$html = get_web_page($imageLink);
		print_r($html);
		if($html['http_code'] == 200){
			if(strlen($html['content']) > 100){
				$ac = fopen((__DIR__).'/cache/img/'.$shortcode,'w');
				fwrite($ac,$html['content']);
				fclose($ac);
				echo $html['content'];
			}
		}

	}
	else{
		echo file_get_contents(THEMEDIR.'/assets/img/default.jpg');
	}