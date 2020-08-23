<?php 
    
    use seregazhuk\PinterestBot\Factories\PinterestBot;

    //global $pinBot;
    //require ROOT.'/pin/vendor/autoload.php';
//
    //$pinBot = PinterestBot::create();
    //$pinBot->auth->login('quuzy@setiabudihitz.com', '48186hasokeyk');
//
    //if ($pinBot->user->isBanned()) {
    //    echo "Account has been banned!\n";
    //    die();
    //}

    function userSave($data = null,$type){
        global $mysqli,$pinBot;

        if($data != null){

            if($type == 'link'){
                $user = $data->graphql->user;
            }else{
                $user = $data->user;
            }

            $instaID        = $user->id;
            $username       = $user->username;
            $followedCount  = $user->edge_followed_by->count;
            $followingCount = $user->edge_follow->count;
            $postsCount     = $user->edge_owner_to_timeline_media->count;
            $fullName       = trim(htmlentities(addslashes($user->full_name)));
            $biography      = trim(htmlentities(addslashes($user->biography)));
            $verify         = $user->is_verified==true?'1':'0';
            $private        = $user->is_private==true?'1':'0';
            $profilePic     = $user->profile_pic_url_hd;

            $ask = $mysqli->query("SELECT * FROM users WHERE username = '".$user->username."'");
            if($ask->num_rows == 0){
                $sql = "INSERT INTO users SET private='".$private."',verify='".$verify."',bio='".$biography."',instaID='".$instaID."',pintBoardID='0',fullName='".$fullName."',username='".$user->username."',followedCount='".$followedCount."',followingCount='".$followingCount."',postsCount='".$postsCount."'";
                $userSave = $mysqli->query($sql);
                if($userSave){
	                $sql = "INSERT INTO seolinks SET url='".$user->username."',fullLink='/instagram/".$user->username."',template='profile-detail',parentID='1',time='".time()."'";
                    $seoSave = $mysqli->query($sql);
                    if($userSave and $seoSave){
                        $result = true;
                    }else{
                        $result = false;
                    }
                }else{
	                $result = false;
                }
            }else{
                $sql = "UPDATE users SET private='".$private."',verify='".$verify."',bio='".$biography."',instaID='".$instaID."',pintBoardID='0',fullName='".$fullName."',followedCount='".$followedCount."',followingCount='".$followingCount."',postsCount='".$postsCount."' WHERE username='".$user->username."'";
                $update = $mysqli->query($sql);
                if($update){
                    $result = true;
                }else{
                    $result = false;
                }
            }

            if($private == '1'){
            	$posts = followedUserPostList($username);
            	if($posts === false){
            		userFollow($instaID);
	            }else{
            		userPostSaveApi($username);
	            }
            }

            return $result;

        }else{
            return false;
        }

    }

    function userPostSaveApi($username){
    	global $mysqli,$pinBot;

	    if($username != null){

            $ins = new Instagram();
            $data = $ins->profile($username);


            foreach($data->graphql->user->edge_owner_to_timeline_media as $p){

                if(isset($p->image_versions2->candidates[0]->url) and !empty($p->image_versions2->candidates[0]->url)){
                    $mediaID            = $p->id;
                    $shortcode          = $p->code;
                    $username           = $p->user->username;
                    $postUrl            = $p->image_versions2->candidates[0]->url;
                    $postDesc           = $p->caption->text??'';
                    $postComment        = 0;
                    $postLike           = 0;
                    $isVideo            = 0;

                    $ask = $mysqli->query("SELECT * FROM userposts WHERE shortcode = '".$shortcode."' AND username='".$username."'");
                    if($ask->num_rows == 0){
                        $sql = "INSERT INTO userposts SET url='".$postUrl."',commentCount='".$postComment."',likeCount='".$postLike."',shortcode='".$shortcode."',username='".$username."',description='".$postDesc."',type='".(($isVideo==1)?'video':'photo')."'";
                        $save = $mysqli->query($sql);
                    }else{
                        $sql = "UPDATE userposts SET url='".$postUrl."',commentCount='".$postComment."',likeCount='".$postLike."',shortcode='".$shortcode."',username='".$username."',description='".$postDesc."',type='".(($isVideo==1)?'video':'photo')."' WHERE shortcode = '".$shortcode."' AND username='".$username."'";
                        $update = $mysqli->query($sql);
                    }

                }
            }

	    }

	    return false;

    }

    function userPostSave($data = null,$type='link'){
        global $mysqli,$pinBot;

        if($data != null){

            if($type == 'link'){
                $user = $data->graphql->user;
            }else{
                $user = $data->user;
            }

            $username = $user->username;
            $posts = $user->edge_owner_to_timeline_media->edges;

            //PHOTO
            foreach($posts as $post){

                $post               = $post->node;
                $shortcode          = $post->shortcode;
                $postDesc           = $mysqli->escape_string($post->edge_media_to_caption->edges[0]->node->text??'');
                $postComment        = $post->edge_media_to_comment->count;
                $postLike           = $post->edge_liked_by->count;
                $postUrl            = $post->display_url;
                $isVideo            = $post->is_video;

                $ask = $mysqli->query("SELECT * FROM userposts WHERE shortcode = '".$shortcode."' AND username='".$username."'");
                if($ask->num_rows == 0){
                    $sql = "INSERT INTO userposts SET url='".$postUrl."',commentCount='".$postComment."',likeCount='".$postLike."',shortcode='".$shortcode."',username='".$username."',description='".$postDesc."',type='".(($isVideo==1)?'video':'photo')."'";
                    $save = $mysqli->query($sql);
                }else{
                    $sql = "UPDATE userposts SET url='".$postUrl."',commentCount='".$postComment."',likeCount='".$postLike."',shortcode='".$shortcode."',username='".$username."',description='".$postDesc."',type='".(($isVideo==1)?'video':'photo')."' WHERE shortcode = '".$shortcode."' AND username='".$username."'";
                    $update = $mysqli->query($sql);
                }

            }
            //PHOTO

            return true;
        }else{
            return false;
        }

    }

    function userFollow($userID){

        try {
            $ins = new Instagram();
            $profile = $ins->follow($userID);
            return true;
        }catch (Exception $err){
            echo $err->getMessage();
        }

    }

    function followedUserPostList($username){

        try {
            $ins = new Instagram();
            $profile = $ins->profile($username);
            $posts   = $profile->edge_owner_to_timeline_media->edges;

            if(isset($posts[0])){
                return $posts;
            }else{
                return false;
            }
        }catch (Exception $err){
            echo $err->getMessage();
        }

    }

    function imageDownload($link){

        $results = get_web_page($link,'',true);
        if($results['http_code'] == '200'){

            $image = file_put_contents(ROOT.'/cache/img/');

        }

    }

    function thousandsCurrencyFormat($num) {

        if($num>1000) {
      
              $x = round($num);
              $x_number_format = number_format($x);
              $x_array = explode(',', $x_number_format);
              $x_parts = array('k', 'm', 'b', 't');
              $x_count_parts = count($x_array) - 1;
              $x_display = $x;
              $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
              $x_display .= $x_parts[$x_count_parts - 1];
      
              return $x_display;
      
        }
      
        return $num;
    }

    function proxies(){
		
		$proxies = [
			'https://av-muhammed.herokuapp.com/',
			'https://av-muhammed2.herokuapp.com/',
			'https://av-muhammed3.herokuapp.com/',
			'https://av-muhammed4.herokuapp.com/',
			'https://av-muhammed5.herokuapp.com/',
			'https://us-elif.herokuapp.com/',  
			'https://us-elif2.herokuapp.com/', 
			'https://us-elif3.herokuapp.com/', 
			'https://us-elif4.herokuapp.com/', 
			'https://us-elif5.herokuapp.com/',
			'https://av-ayda.herokuapp.com/',   
			'https://av-ayda2.herokuapp.com/',  
			//'https://av-ayda3.herokuapp.com/',  
			//'https://av-ayda4.herokuapp.com/',  
			'https://av-ayda5.herokuapp.com/', 
			'https://av-mustafa.herokuapp.com/',   
			'https://av-mustafa2.herokuapp.com/',  
			'https://av-mustafa3.herokuapp.com/',  
			//'https://av-mustafa4.herokuapp.com/',  
			'https://av-mustafa5.herokuapp.com/', 
			'https://av-bensu.herokuapp.com/',   
			'https://av-bensu2.herokuapp.com',   
			'https://av-bensu3.herokuapp.com/',  
			//'https://av-bensu4.herokuapp.com/',  
			'https://av-bensu5.herokuapp.com/',
			'https://av-boran.herokuapp.com/',   
			'https://av-boran2.herokuapp.com/',  
			'https://av-boran3.herokuapp.com/',  
			'https://av-boran4.herokuapp.com/',  
			'https://av-boran5.herokuapp.com/',
			'https://av-ahmet.herokuapp.com/',   
			//'https://av-ahmet2.herokuapp.com/',  
			'https://av-ahmet3.herokuapp.com/',  
			'https://av-ahmet4.herokuapp.com/',  
			'https://av-ahmet5.herokuapp.com/',
			'https://av-hasan.herokuapp.com/', 
			'https://av-hasan2.herokuapp.com/', 
			'https://av-hasan3.herokuapp.com/', 
			'https://av-hasan4.herokuapp.com/', 
			'https://av-hasan5.herokuapp.com/',
			'https://av-arif.herokuapp.com/',   
			'https://av-arif2.herokuapp.com/',  
			'https://av-arif3.herokuapp.com/',  
			'https://av-arif4.herokuapp.com/',  
			'https://av-arif5.herokuapp.com/',  
			'https://av-huseyin.herokuapp.com/',   
			'https://av-huseyin2.herokuapp.com/',  
			'https://av-huseyin3.herokuapp.com/',  
			'https://av-huseyin4.herokuapp.com/',  
			'https://av-huseyin5.herokuapp.com/',
			'https://av-sergen.herokuapp.com/',   
			'https://av-sergen2.herokuapp.com/',  
			'https://av-sergen3.herokuapp.com/',  
			'https://av-sergen4.herokuapp.com/',  
			'https://av-sergen5.herokuapp.com/', 
			'https://av-ismail.herokuapp.com/',  
			'https://av-ismail2.herokuapp.com/', 
			'https://av-ismail3.herokuapp.com/', 
			'https://av-ismail4.herokuapp.com/', 
			'https://av-ismail5.herokuapp.com/',
			'https://av-aydemir.herokuapp.com/',   
			'https://av-aydemir2.herokuapp.com/',  
			'https://av-aydemir3.herokuapp.com/',  
			'https://us-aydemir4.herokuapp.com/',  
			'https://us-aydemir5.herokuapp.com/',
		];
		
		return $proxies[rand(0,(count($proxies)-1))];
		
    }
    
    function get_web_page($url){

    	//$token = getCsrfToken(ROOT.'/cache/cookie/user.hsn');

	    //$ip  = '1.1.1.1';
	    //$token = getCsrfToken($html);
	    $ip  = rand(1,255).'.'.rand(1,255).'.'.rand(1,255).'.'.rand(1,255);

	    $header[0]  = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
	    //$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";

	    $header[] = "accept-encoding: gzip, deflate, br";
	    //$header[] = 'cookie: ig_did='.$token['ig_did'].'; csrftoken='.$token['csrftoken'].'; mid='.$token['mid'].'; rur=PRN; urlgen="{\"'.$ip.'\": 12735}:1j9ru3:n1gIo-95YSVtN0zRcAGwjUp-kB4"';
	    $header[] = "Cache-Control: max-age=0";
	    $header[] = "Connection: keep-alive";
	    $header[] = "Keep-Alive: 300";
	    $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	    $header[] = "Accept-Language: en-us,en;q=0.5";
	    $header[] = "Pragma: no-cache"; // browsers = blank
	    //$header[] = "X_FORWARDED_FOR: " . $ip;
	    //$header[] = "REMOTE_ADDR: " . $ip;
	    //$header[] = "Referer: https://www.instagram.com/";
	    //$header[] = "x-csrftoken: ".$token['csrftoken'];
	    //$header[] = "Host: hayatikodla.com";
	    //$header[] = "Origin: instagram.com";

        $options = array(
	        CURLOPT_HTTPHEADER     => $header,     // return web page
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => true,     //return headers in addition to content
            CURLOPT_FOLLOWLOCATION => false,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_SSL_VERIFYPEER => false,     // Validate SSL Cert
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36',
            //CURLOPT_COOKIESESSION  => true,
            //CURLOPT_COOKIEJAR      => ROOT.'/cache/cookie/user.hsn',
	        //CURLOPT_COOKIEFILE     => ROOT.'/cache/cookie/user.hsn',
	        CURLOPT_REFERER        => 'https://www.instagram.com/'
        );

	    $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $rough_content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header_content = substr($rough_content, 0, $header['header_size']);
        $body_content = trim(str_replace($header_content, '', $rough_content));
        $pattern = "#Set-Cookie:\\s+(?<cookie>[^=]+=[^;]+)#m"; 
        preg_match_all($pattern, $header_content, $matches); 
        $cookiesOut = implode("; ", $matches['cookie']);

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['headers']  = $header_content;
        $header['content'] = $body_content;
        $header['cookies'] = $cookiesOut;
        return $header;

    }

    function linker($string=false){

        return mb_strtolower(preg_replace('|@([a-zA-Z0-9_.]+)|is','<a href="//quuzy.com/instagram/$1/">@$1</a> ',$string),'utf8');
 
     }

	function getCsrfToken($cookiePath = ''){

    	if(file_exists($cookiePath)){

    		echo $cookie = file_get_contents($cookiePath);

    		preg_match('|mid(.*)|i', $cookie,$mid);
    		preg_match('|csrftoken(.*)|i', $cookie,$csrftoken);
    		preg_match('|ig_did(.*)|i', $cookie,$ig_did);

    		return [
    			'mid'       => trim($mid[1]),
    			'csrftoken' => trim($csrftoken[1]),
    			'ig_did'    => trim($ig_did[1]),
		    ];
	    }

    	return false;
	}