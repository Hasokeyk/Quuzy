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
            $followedCount  = $user->edge_followed_by->count;
            $followingCount = $user->edge_follow->count;
            $postsCount     = $user->edge_owner_to_timeline_media->count;
            $fullName       = $user->full_name;
            $biography      = $user->biography;
            $profilePic     = $user->profile_pic_url_hd;

            $ask = $mysqli->query("SELECT * FROM users WHERE username = '".$user->username."'");
            if($ask->num_rows == 0){
                $sql = "INSERT INTO users SET instaID='".$instaID."',pintBoardID='0',fullName='".$fullName."',username='".$user->username."',followedCount='".$followedCount."',followingCount='".$followingCount."',postsCount='".$postsCount."'";
                $userSave = $mysqli->query($sql);
                if($userSave){
	                $sql = "INSERT INTO seolinks SET url='".$user->username."',fullLink='/instagram/".$user->username."',template='profile-detail',parentID='1',time='".time()."'";
                    $seoSave = $mysqli->query($sql);
                    if($userSave and $seoSave){
                        return true;
                    }else{
                        return false;
                    }
                }else{
	                return false;
                }
            }else{
                $sql = "UPDATE users SET instaID='".$instaID."',pintBoardID='0',fullName='".$fullName."',followedCount='".$followedCount."',followingCount='".$followingCount."',postsCount='".$postsCount."' WHERE username='".$user->username."'";
                $update = $mysqli->query($sql);
                if($update){
                    return true;
                }else{
                    return false;
                }
            }

        }else{
            return false;
        }

    }

    function userPostSave($data = null,$type){
        global $mysqli,$pinBot;

        if($data != null){

            if($type == 'link'){
                $user = $data->graphql->user;
            }else{
                $user = $data->user;
            }

            //print_r($user);

            $username = $user->username;
            $posts = $user->edge_owner_to_timeline_media->edges;

            //$boards = $pinBot->boards->forMe();
            //foreach($boards as $b){
            //    if($username == $b['name']){
            //        $boardID = $b['id'];
            //        break;
            //    }
            //}

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
                    $sql = "INSERT INTO userposts SET commentCount='".$postComment."',likeCount='".$postLike."',shortcode='".$shortcode."',username='".$username."',description='".$postDesc."',type='".(($isVideo==1)?'video':'photo')."'";
                    $save = $mysqli->query($sql);
                }else{
                    $sql = "UPDATE userposts SET commentCount='".$postComment."',likeCount='".$postLike."',shortcode='".$shortcode."',username='".$username."',description='".$postDesc."',type='".(($isVideo==1)?'video':'photo')."' WHERE shortcode = '".$shortcode."' AND username='".$username."'";
                    $update = $mysqli->query($sql);
                }

            }
            //PHOTO

            return true;
        }else{
            return false;
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

        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => true,     //return headers in addition to content
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_SSL_VERIFYPEER => false,     // Validate SSL Cert
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0',
            CURLOPT_COOKIESESSION  => true,
            CURLOPT_COOKIEJAR      => ROOT.'/cache/cookie/user.hsn',
	        CURLOPT_COOKIEFILE     => ROOT.'/cache/cookie/user.hsn'
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