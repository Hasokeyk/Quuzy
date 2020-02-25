<?php
    require THEMEDIR."header.php";

    $userInfo = $mysqli->query("SELECT * FROM users WHERE username = '".$urlParse['subFolder']."'")->fetch_assoc();
    $adsLimit = 4;

?>

<div class="profile-detail">

    <div class="profile-info">

        <div class="profile-pic">
            <div class="profile-circle">
                <img src="/img/u/<?=$userInfo['username']?>/" alt="<?=$userInfo['fullName']?>">
            </div>
        </div>

        <div class="profile-fullName">
            <?=$userInfo['fullName']?>
        </div>

        <div class="profile-username">
            @<?=$userInfo['username']?>
        </div>

        <div class="profile-istatistic">

            <ul>
                <li>
                    <div class="count"><?=thousandsCurrencyFormat($userInfo['postsCount'])?></div>
                    <div class="text">POST</div>
                </li>
                <li>
                    <div class="count"><?=thousandsCurrencyFormat($userInfo['followedCount'])?></div>
                    <div class="text">FOLLOWERS</div>
                </li>
                <li>
                    <div class="count"><?=thousandsCurrencyFormat($userInfo['followingCount'])?></div>
                    <div class="text">FOLLOWING</div>
                </li>
            </ul>

        </div>

        <div class="profile-menu">

            <ul>
                <li>
                    <a href="/">
                        <div class="icon">
                            <i class="fad fa-home-alt"></i>
                        </div>
                        <div class="text">
                            Home
                        </div>
                    </a>
                </li>
                <li class="active">
                    <div class="icon">
                        <i class="fad fa-image"></i>
                    </div>
                    <div class="text">
                        Feed
                    </div>
                </li>
                <li>
                    <div class="icon">
                        <i class="fad fa-portrait"></i>
                    </div>
                    <div class="text">
                        Stories
                    </div>
                </li>
                <li>
                    <div class="icon">
                        <i class="fad fa-tv-retro"></i>
                    </div>
                    <div class="text">
                        IGTV
                    </div>
                </li>
            </ul>

        </div>

    </div>

    <div class="profile-content">

        <!--USER PROFILES-->
        <div class="last-user-profiles">
            <h1>Similar Instagram Profiles</h1>
            <div class="users">
			    <?php
				    $users = $mysqli->query("SELECT * FROM users ORDER BY RAND() LIMIT 15");
				    $similarProfil = [];
				    if($users->num_rows > 0){
					    while($user = $users->fetch_assoc()){
						    $similarProfil[] = $user;
                    ?>
                    <a href="/instagram/<?=$user['username']?>/" class="user">
                        <div class="user-circle">
                            <img src="https://quuzy.com/img/u/<?=$user['username']?>/" alt="<?=$user['fullName']?>">
                        </div>
                    </a>
                    <?php
					    }
				    }
			    ?>
            </div>
        </div>
        <!--USER PROFILES-->

        <div class="profile-posts">
            <h1><?=$userInfo['fullName']??$userInfo['username']?>'s Posts</h1>
            <div class="posts">
            <?php
                $posts = $mysqli->query("SELECT * FROM userposts WHERE username='".$urlParse['subFolder']."' ORDER BY id DESC");
                if($posts->num_rows > 0){
                    $ads = 0;
                    while($post = $posts->fetch_assoc()){
            ?>
                <div  class="post play <?=$post['type']?>" data-shortcode="<?=$post['shortcode']?>">
                    <div class="post-img">
                        <?php
                            if($post['type'] == 'photo'){
                        ?>
                        <a href="/img/p/<?=$post['shortcode']?>/" data-fancybox="gallery">
                            <img src="/img/p/<?=$post['shortcode']?>/" alt="<?=$post['description']?>"/>
                        </a>
                        <?php
                            }else{
                        ?>
                        <img src="/img/p/<?=$post['shortcode']?>/" alt="<?=$post['description']?>"/>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="post-desc" style="display:none">
                        <p>
                        <?//=linker($post['description'])?>
                        </p>
                    </div>
                    <div class="post-info">
                        <div class="post-info-detail">
                            <ul>
                                <li>
                                    <div class="icon"><i class="fas fa-heart"></i></div>
                                    <div class="text"><?=thousandsCurrencyFormat($post['likeCount'])?></div>
                                </li>
                                <li>
                                    <div class="icon"><i class="fal fa-comment"></i></div>
                                    <div class="text"><?=thousandsCurrencyFormat($post['commentCount'])?></div>
                                </li>
                                <li class="download-btn">
                                    <div class="icon"><i class="fas fa-download"></i></div>
                                    <div class="text"><a href="/img/p/<?=$post['shortcode']?>/" download="<?=$post['shortcode']?>.png">Download</a></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php
                        if($ads % 6 == 0 and $ads <= $adsLimit){
            ?>
                <div class="post ads">
                    <div class="post-img">
                        <!-- Profile Detay - 300*300 -->
                        <ins class="adsbygoogle"
                            style="display:inline-block;width:300px;height:300px"
                            data-ad-client="ca-pub-9896875941850273"
                            data-ad-slot="6237119990"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                    <div class="post-desc" style="display:none">
                        <p>
                        <?=linker($post['description'])?>
                        </p>
                    </div>
                    <div class="post-info">
                        <div class="post-info-detail">
                            <ul>
                                <li>
                                    <div class="icon"><i class="fas fa-heart"></i></div>
                                    <div class="text"><?=thousandsCurrencyFormat(rand(111,9999))?></div>
                                </li>
                                <li>
                                    <div class="icon"><i class="fal fa-comment"></i></div>
                                    <div class="text"><?=thousandsCurrencyFormat(rand(111,9999))?></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php
                        }
                        $ads++;
	                    $adsLimit++;
                    }
                }
            ?>
            </div>
        </div>

    </div>

</div>

<?php 
    require THEMEDIR."footer.php";
?>