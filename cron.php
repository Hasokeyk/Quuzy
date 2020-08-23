<?php 

    global $pinBot;
    require "48186.php";
    require ROOT.'/keyb/vendor/autoload.php';
    set_time_limit(0);

    $username = 'home.decor.pin';
    $password = 'hasan.hayati@KODLA20';

    $kodlar = [
        '93760152',
        '16034928',
        '39680752',
        '81736902',
        '51783062',
    ];

    use seregazhuk\PinterestBot\Factories\PinterestBot;

    /*
    if(isset($_GET['action']) and $_GET['action'] != 'cacheDel'){

	    $pinBot = PinterestBot::create();
	    $result = $pinBot->auth->login('pinme@quuzy.com', '48186hasokeyk',true);

	    //$pinBot->getHttpClient()->useProxy('45.77.96.231', '8888');
	    $someCookieValue = $pinBot->getHttpClient()->cookie('cookieName');
	    $pinBot->getHttpClient()->setCookiesPath((__DIR__).'/cache/cookie/');
	    $currentPath = $pinBot->getHttpClient()->getCookiesPath();

	    if ($pinBot->auth->isLoggedIn()) {
		    //echo 'Sorun yok <br>';
	    }else{
		    echo 3;
		    $cookies = $pinBot->getHttpClient()->cookies();
		    //$pinBot->getHttpClient()->removeCookies();
		    print_r($cookies);
		    exit;
	    }

	    if (!$result) {
		    echo $pinBot->getLastError();
		    die();
	    }

	    $error = $pinBot->getLastError();
	    echo $error;

	    if ($pinBot->user->isBanned()) {
		    echo "Account has been banned!\n";
		    die();
	    }

    }
    */

    if(isset($_GET['action'])){

	    if($_GET['action'] == 'photoShare'){

            $ig = new \InstagramFollowers\Instagram();

            try {
                $loginResponse = $ig->login($username, $password);
            }catch (Exception $err){
                echo $err->getMessage();
                exit();
            }

			$tags = [
				'Home Decor',
				'Home Style',
				'Home',
				'home office',
				'home organization',
				'home staging',
				'home stylist',
				'home Store',
			];
			$tagText = $tags[array_rand($tags,1)];
		    $pins = $pinBot->pins->search($tagText,'3')->toArray();
		    $pins = $pins[0]['objects']??$pins;
		    foreach($pins as $pinner){
				$picUrl     = $pinner['images']['orig']['url'];
				$picDesc    = $pinner['description'];
				$picDesc    .= '#homedecor #lifestyle #homestyle #homestudio #homestaging';

				$fileName = (__DIR__).'/temp.jpg';
				$file = file_get_contents($picUrl);
				$file = file_put_contents($fileName, $file);

				if(file_exists($fileName)){
					try{

                        $ig->mediaRequest->UploadPhoto($fileName, $picDesc);

                        //get response from configure
                        $candidates = $ig->mediaRequest->configureSinglePhotoResponse->getMedia()->getImageVersions2()->getCandidates();
                        $first_candidate = $candidates[0];

                        if ($ig->mediaRequest->uploadPhotoResponse->getStatus() == 'ok'){
                            echo "File Uploaded, your upload id is: ", $ig->mediaRequest->uploadPhotoResponse->getUploadId(), "\n";
                        }

					}catch(Exception $err){
						echo 'Hata: '.$err->getMessage();
					}
				}else{
					echo $fileName.' dosya yok';
					break;
				}


				sleep(3);
			}

	    }
	    else if($_GET['action'] == 'pin2pin'){

	        $sql = "SELECT
                        U.id,
                        U.username,
                        U.fullName,
                        U.pintBoardID,
                        UP.pinID,
                        UP.shortcode,
                        UP.description
                    FROM
                        users AS U,
                        userposts AS UP
                    WHERE
                        U.username = UP.username AND
                        U.pintBoardID = 0 AND
                        UP.pinID = 0 AND
                        U.private = 0
                    ORDER BY
                        U.id
                    DESC";

	        /*
	         * SELECT
                    U.id,
                    U.username,
                    U.fullName,
                    U.pintBoardID,
                    UP.pinID,
                    UP.shortcode,
                    UP.description
                FROM
                    users AS U,
                    userposts AS UP
                WHERE
                    U.username = UP.username AND
                    U.pintBoardID = 0 AND
                    UP.pinID = 0 AND
                    U.private = 0 AND
                    U.id = (SELECT
                                id
                            FROM
                                users AS U
                            WHERE
                                (pintBoardID = 0 OR pintBoardID = '') AND
                                (SELECT COUNT(id) FROM userposts WHERE username = U.username) > 1
                            ORDER BY
                                id
                            DESC
                            LIMIT 1)
                ORDER BY
                    U.id
                DESC
	        */

		    $users = $mysqli->query($sql);

		    if($users->num_rows > 0){

			    $desc = '#photographytips #inspiredpictures #picturestumblr #tumblrphoto #instagramtips #instagramlive #instagramname #instagrampost #instagramlove #instagrampictures #beautyinstagram #goodinstagram #funnyinstagram #loveinstagram #love #background #Wallpaper #beautiful';

			    while($user = $users->fetch_assoc()){

		    		if($user['pintBoardID'] == '0' or empty($user['pintBoardID'])){

					    $pinBot->boards->create($user['username'], $user['fullName'].' '.$desc);
					    sleep(1);
					    $boards = $pinBot->boards->forMe();
					    foreach($boards as $b){
					        if($user['username'] == $b['name']){
					            $boardID = $b['id'];
					            break;
					        }
					    }

					    $mysqli->query("UPDATE users SET pintBoardID = '".$boardID."' WHERE id = '".$user['id']."'");
					    $pinBot->boards->update($boardID, [
						    'category'    => 'photography',
					    ]);

				    }else{
					    $boardID = $user['pintBoardID'];
				    }

				    $desc = '#photographytips #inspiredpictures #picturestumblr #tumblrphoto #instagramtips #instagramlive #instagramname #instagrampost #instagramlove #instagrampictures #beautyinstagram #goodinstagram #funnyinstagram #loveinstagram #love #background #Wallpaper #beautiful';

				    $pin = $pinBot->pins->create(
					    'https://quuzy.com/img/p/'.$user['shortcode'].'/',
					    $boardID,
					    $desc,
					    'https://quuzy.com/instagram/'.$user['username'].'/',
					    $user['username']
				    );

				    if($pin !== false){
					    echo 'Paylaşıldı'.$pin['id']."\n <br>";
					    $mysqli->query("UPDATE userposts SET pinID ='".$pin['id']."' WHERE shortcode='".$user['shortcode']."'");
				    }else{
					    echo $pinBot->getLastError();
					    echo '<a href="https://quuzy.com/img/p/'.$user['shortcode'].'/" target="_blank">'.$user['shortcode'].'</a> Paylaşılamadı'."\n";
					    break;
				    }

			    }

		    }

	    }
	    else if($_GET['action'] == 'tag2pin'){

		    $boardsID = [
		    	'857091441523499054' => 'homedecor'
		    ];

		    foreach($boardsID as  $boardID => $tag){

		    	$boardID = (String) $boardID;
				$tagJson = json_decode(file_get_contents('https://www.instagram.com/explore/tags/'.$tag.'/?__a=1'));
				$tagPost = $tagJson->graphql->hashtag->edge_hashtag_to_media->edges;

				foreach($tagPost as $post){

					$p = $post->node;

					$pin = $pinBot->pins->create(
						$p->display_url,
						$boardID,
						'#homedecor #homedecoration #homedecorating #homedecore #homedecorations #homedecorideas #homedecorlovers #homedecorblogger #homedecors #homedecorator #homedecorinspo #homedecorationideas #homedecorate #homedecorinspiration #homedecormurah #homedecorlover #homedecorlove #homedecorblog #homedecorsg #homedecoratingideas #homedecorloversid #homedecorindo #homedecorindonesia #homedecorjakarta #homedecorshop #homedecoridea #homedecorloversfamilytangerang #homedecorstore #homedecortips #homedecoracao',
						'https://quuzy.com/',
						'Quuzy - Home Decor '.date('d.m.Y')
					);

					if($pin !== false){
						echo 'Paylaşıldı'.$pin['id']."\n <br>";
					}else{
						print_r($pinBot);
						echo $pinBot->getLastError();
						break;
					}
					sleep(1);
					break;

				}


		    }

		    //$boards = $pinBot->boards->forMe();
		    //print_r($boards);

	    }
	    else if($_GET['action'] == 'openBoard'){

	    	$boardName = 'Home Decor';
		    $pinBot->boards->create($boardName, '#homedecor #homedecoration #homedecorating #homedecore #homedecorations #homedecorideas #homedecorlovers #homedecorblogger #homedecors #homedecorator #homedecorinspo #homedecorationideas #homedecorate #homedecorinspiration #homedecormurah #homedecorlover #homedecorlove #homedecorblog #homedecorsg #homedecoratingideas #homedecorloversid #homedecorindo #homedecorindonesia #homedecorjakarta #homedecorshop #homedecoridea #homedecorloversfamilytangerang #homedecorstore #homedecortips #homedecoracao');
		    sleep(1);
		    $boards = $pinBot->boards->forMe();
		    foreach($boards as $b){
			    if($boardName == $b['name']){
				    $boardID = $b['id'];
				    break;
			    }
		    }

		    $pinBot->boards->update($boardID, [
			    'category'    => 'home_decor',
		    ]);

		    echo $boardID;

	    }
	    else if($_GET['action'] == 'cacheDel'){

		    $imgs = glob(ROOT.'/cache/img/*');
		    foreach ($imgs as $img){
			    unlink($img);
		    }
		    echo count($imgs).' Görsel Silindi'."<br> \n";


		    $sitemaps = glob(ROOT.'/cache/sitemap/*');
		    foreach ($sitemaps as $sitemap){
			    unlink($sitemap);
		    }
		    echo count($sitemaps).' Sitemap Silindi'."<br> \n";

		    $htmls = glob(ROOT.'/cache/html/*');
		    foreach ($htmls as $html){
			    unlink($html);
		    }
		    echo count($htmls).' Html Cache Silindi'."<br> \n";
	    }
	    else if($_GET['action'] == 'cacheDelHtml'){

		    $htmls = glob(ROOT.'/cache/html/*');
		    foreach ($htmls as $html){
			    unlink($html);
		    }
			echo count($htmls).' Html Cache Silindi'."<br> \n";
			
	    }

    }
