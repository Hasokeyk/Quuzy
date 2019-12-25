<?php 

    global $pinBot;
    require "48186.php";
    require ROOT.'/pin/vendor/autoload.php';
    require ROOT.'/keyb/vendor/autoload.php';

    use seregazhuk\PinterestBot\Factories\PinterestBot;

    if(isset($_GET['action'])){
	    if($_GET['action'] == 'pin2pin'){

		    $pinBot = PinterestBot::create();
		    $result = $pinBot->auth->login('quuzy@setiabudihitz.com', '48186hasokeyk',true);

		    //$pinBot->getHttpClient()->useProxy('45.77.96.231', '8888');
		    $someCookieValue = $pinBot->getHttpClient()->cookie('cookieName');
		    $pinBot->getHttpClient()->setCookiesPath((__DIR__).'/cache/cookies/');
		    $currentPath = $pinBot->getHttpClient()->getCookiesPath();

		    if ($pinBot->auth->isLoggedIn()) {
			    echo 'Sorun yok <br>';
		    }else{
			    echo 3;
			    $cookies = $pinBot->getHttpClient()->cookies();
			    //$pinBot->getHttpClient()->removeCookies();
			    print_r($cookies);
		    }

		    if (!$result) {
			    echo $pinBot->getLastError();
			    die();
		    }

		    //$error = $pinBot->getLastError();
		    //echo $error;

		    if ($pinBot->user->isBanned()) {
			    echo "Account has been banned!\n";
			    die();
		    }

		    $nonPinPost = $mysqli->query("SELECT * FROM users AS U,userposts AS UP WHERE U.username = UP.username AND U.pintBoardID != 0 AND UP.pinID = 0 LIMIT 10");
		    if($nonPinPost->num_rows > 0){
			    while($p = $nonPinPost->fetch_assoc()){

				    $pin = $pinBot->pins->create(
					    'https://quuzy.com/img/p/'.$p['shortcode'].'/',
					    $p['pintBoardID'],
					    substr($p['description'],0,400),
					    'https://quuzy.com/instagram/'.$p['username'].'/',
					    $p['username'],
                );
				    sleep(1);
				    if($pin !== false){
					    echo 'Paylaşıldı'.$pin['id']."\n <br>";
					    $mysqli->query("UPDATE userposts SET pinID ='".$pin['id']."' WHERE shortcode='".$p['shortcode']."'");
				    }else{
					    echo $pinBot->getLastError();
					    echo '<a href="https://quuzy.com/img/p/'.$p['shortcode'].'/" target="_blank">'.$p['shortcode'].'</a> Paylaşılamadı'."\n";
					    break;
				    }

			    }
		    }else{
			    echo 'Paylaşım yok';
		    }
	    }
	    else if($_GET['action'] == 'instaID'){

	    	$nonInstaID = $mysqli->query("SELECT * FROM users WHERE instaID = 0 LIMIT 20");
			if($nonInstaID->num_rows > 0){
				while ($user = $nonInstaID->fetch_assoc()){



				}
			}

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
    }
