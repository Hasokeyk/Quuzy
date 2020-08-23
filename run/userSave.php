<?php
	
	use Phpfastcache\Helper\Psr16Adapter;
	
	require (__DIR__)."/../48186.php";
	require KEYBDIR.'vendor/autoload.php';
	
	$instagram = new \InstagramScraper\Instagram();
	$username = $argv[1];
	
	$user = $instagram->getAccount($username);
	
	$bio = $user->getBiography();
	$username = $user->getUsername();
	$instaID = $user->getId();
	$fullName = $user->getFullName();
	$followedCount = $user->getFollowedByCount();
	$followingCount = $user->getFollowsCount();
	$postsCount = $user->getMediaCount();
	$private = $user->isPrivate();
	$verify = $user->isVerified();
	
	
	if($private == true){
		$instagram = \InstagramScraper\Instagram::withCredentials($instUsername, $instPassword, new Psr16Adapter('Files'));
		$instagram->login();
		$instagram->follow($instaID);
	}
	
	$ask = $mysqli->query("SELECT * FROM users WHERE username = '".$username."'");
	if($ask->num_rows == 0){
		
		$sql = "INSERT INTO users SET private='".($private==true?'1':'0')."', verify='".($verify==true?'1':'0')."', bio='".$bio."', instaID='".$instaID."', pintBoardID='0', fullName='".$fullName."', username='".$username."', followedCount='".$followedCount."', followingCount='".$followingCount."', postsCount='".$postsCount."'";
		$userSave = $mysqli->query($sql);
		if($userSave){
			$sql = "INSERT INTO
						seolinks
					SET
						url='".$username."',
						fullLink='/instagram/".$username."',
						template='profile-detail',
						parentID='1',
						time='".time()."'";
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
		
		$sql = "UPDATE users SET private='".$private."', verify='".$verify."', bio='".$bio."', instaID='".$instaID."', pintBoardID='0', fullName='".$fullName."', username='".$username."', followedCount='".$followedCount."', followingCount='".$followingCount."', postsCount='".$postsCount."' WHERE username='".$username."'";
		$update = $mysqli->query($sql);
		if($update){
			$result = true;
		}else{
			$result = false;
		}
		
	}
	
	print_r($result);
	