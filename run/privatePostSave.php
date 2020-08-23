<?php
	
	use Phpfastcache\Helper\Psr16Adapter;
	
	require (__DIR__)."/../48186.php";
	require KEYBDIR.'vendor/autoload.php';
	
	$instagram = \InstagramScraper\Instagram::withCredentials($instUsername, $instPassword, new Psr16Adapter('Files'));
	$instagram->login(true);
	$username = $argv[1];
	
	$posts = $instagram->getMedias($username,30);
	
	foreach($posts as $post){
		
		$shortcode          = $post->getShortCode();
		$postDesc           = $mysqli->escape_string($post->getAltText()??'');
		$postComment        = $post->getCommentsCount();
		$postLike           = $post->getLikesCount();
		$postUrl            = $post->getImageThumbnailUrl();
		$isVideo            = $post->getType();
		
		$ask = $mysqli->query("SELECT * FROM userposts WHERE shortcode = '".$shortcode."' AND username='".$username."'");
		if($ask->num_rows == 0){
			$sql = "INSERT INTO userposts SET url='".$postUrl."',commentCount='".$postComment."',likeCount='".$postLike."',shortcode='".$shortcode."',username='".$username."',description='".$postDesc."',type='".($isVideo)."'";
			$save = $mysqli->query($sql);
			if($save){
				$result = true;
			}else{
				$result = false;
			}
		}else{
			$sql = "UPDATE userposts SET url='".$postUrl."',commentCount='".$postComment."',likeCount='".$postLike."',shortcode='".$shortcode."',username='".$username."',description='".$postDesc."',type='".($isVideo)."' WHERE shortcode = '".$shortcode."' AND username='".$username."'";
			$update = $mysqli->query($sql);
			if($update){
				$result = true;
			}else{
				$result = false;
			}
		}
	
	}
	
	print_r($result);
	