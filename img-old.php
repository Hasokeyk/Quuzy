<?php 

    require "48186.php";
    require ROOT."/keyb/functions.php";

    if(!isset($_GET['test'])){
	    header('Content-Type: image/jpeg');
    }

    if(isset($_GET['shortcode']) and !empty($_GET['shortcode'])){

        $shortcode  = trim(strip_tags($_GET['shortcode']));
        $type       = trim(strip_tags($_GET['type']));

        if(file_exists((__DIR__).'/cache/img/'.$shortcode)){
            $file = (__DIR__).'/cache/img/'.$shortcode;
            $last_modified_time = filemtime($file); 
            $etag = md5_file($file);

            header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT"); 
            header("Etag: $etag"); 
            header('Content-Length: ' . filesize($file));
			$img = readfile((__DIR__).'/cache/img/'.$shortcode);
        }else{

            if($type == 'user'){
                if(is_numeric($shortcode)){
                    $userID = true;
                    $insLink = 'https://www.instagram.com/graphql/query/?query_hash=c9100bf9110dd6361671f113dd02e7d6&variables={"user_id":"'.$shortcode.'","include_reel":true}';
                }else{
                    $insLink = 'https://www.instagram.com/'.$shortcode.'/';
                }
            }else{
                $postID = true;
                //$insLink = 'https://www.instagram.com/p/'.$shortcode.'/';
                $insLink = 'https://www.instagram.com/graphql/query/?query_hash=c9100bf9110dd6361671f113dd02e7d6&variables={"shortcode":"'.$shortcode.'"}';
            }

            $html = get_web_page($insLink);
	        if(isset($_GET['test'])){
		       print_r($html);
		       exit;
	        }
            if($html['http_code'] == 200){

                if(isset($userID) and $userID == true){
                    $imageLink = json_decode($html['content']);
                    $imageLink = $imageLink->data->user->reel->user->profile_pic_url;
                }else if(isset($postID) and $postID == true){

                    $imageLink = json_decode($html['content']);
                    $imageLink = $imageLink->data->shortcode_media->display_url;

                }else{
                    preg_match('|_sharedData(.*?)=(.*?);<\/script>|is',$html['content'],$sonuc);
                
                    if(!isset($sonuc[2])){
                        echo 'Resim Yok';
                        exit;
                    }
                    
                    $media = json_decode($sonuc[2]);
                    if($type == 'user'){
                        $imageLink = $media->entry_data->ProfilePage[0]->graphql->user->profile_pic_url;
                    }else{
                        $imageLink = $media->entry_data->PostPage[0]->graphql->shortcode_media->display_url;
                    }
                }
                
                $html = get_web_page($imageLink);
                if($html['http_code'] == 200){
                    if(strlen($html['content']) > 100){
                        //$ac = fopen((__DIR__).'/cache/img/'.$shortcode,'w');
                        //fwrite($ac,$html['content']);
                        //fclose($ac);
                        echo $html['content'];
                    }
                }
				
            }else{
                echo file_get_contents(THEMEDIR.'/assets/img/default.jpg');
            }

        }

    }else{
        echo file_get_contents(THEMEDIR.'/assets/img/default.jpg');
    }