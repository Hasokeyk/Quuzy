<?php

	require "48186.php";
	require ROOT."/keyb/vendor/autoload.php";
	require ROOT."/keyb/functions.php";

    $username = 'home.decor.pin';
    $password = 'hasan.hayati@KODLA20';

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
                if($html['http_code'] == 200){
                    $imageLink = json_decode($html['content']);
                    if($imageLink != null){
                        $imageLink = $imageLink->graphql->user->profile_pic_url_hd;
                    }else{
                        echo file_get_contents(THEMEDIR.'/assets/img/default.jpg');
                        exit;
                    }
                }else{
                    $ins = new Instagram();
                    $profil = $ins->profile($shortcode);
                    $imageLink = $profil->profile_pic_url_hd;
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
                    $ins = new Instagram();
                    $post = $ins->post($shortcode);
                    if(isset($post->display_url)){
                        $imageLink = $post->display_url;
                    }else{
                        echo file_get_contents(THEMEDIR.'/assets/img/default.jpg');
                        exit;
                    }
				}
			}

		}else if($type == 'privatephoto'){

			if(file_exists((__DIR__).'/cache/img/'.$shortcode)){
				$file = (__DIR__).'/cache/img/'.$shortcode;
				$last_modified_time = filemtime($file);
				$etag = md5_file($file);

				header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT");
				header("Etag: $etag");
				header('Content-Length: ' . filesize($file));
				$img = readfile((__DIR__).'/cache/img/'.$shortcode);
			}else{
				$ask = $mysqli->query("SELECT * FROM userposts WHERE shortcode = '".$shortcode."'")->fetch_array();
				if(isset($ask['url']) and !empty($ask['url'])){
					$imageLink = $ask['url'];
				}else if(isset($ask['id'],$ask['url']) and !empty($ask['id']) and empty($ask['url'])){
					$imageLink = THEMEDIR.'assets/img/default.jpg';
					$mysqli->query("DELETE FROM userposts WHERE id = '".$ask['id']."'");
					@unlink(ROOT.'/cache/html/'.md5($shortcod).'.html');
				}else{
					$imageLink = THEMEDIR.'assets/img/default.jpg';
				}
			}

		}
		else{
			echo file_get_contents(THEMEDIR.'/assets/img/default.jpg');
			exit;
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

	}
	else{
		echo file_get_contents(THEMEDIR.'/assets/img/default.jpg');
	}