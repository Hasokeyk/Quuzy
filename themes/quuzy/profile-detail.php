<?php
    require THEMEDIR."header.php";

    $userInfo = $mysqli->query("SELECT * FROM users WHERE username = '".$urlParse['folder']."'")->fetch_assoc();
    $adsLimit = 8;

    $cdn = '//';
    
    if($userInfo['private'] == '1'){
    	$imgLink = $cdn.'quuzy.com/img/p/p/';
    }else{
	    $imgLink = $cdn.'quuzy.com/img/p/';
    }

?>

<section class="profile-detail">

    <div class="profile-info">

        <div class="profile-pic">
            <div class="profile-circle">
                <img src="//quuzy.com/img/u/<?=$userInfo['username']?>/?f=auto" alt="<?=$userInfo['fullName']?>">
            </div>
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

	    <div class="profile-fullName">
		    <?=$userInfo['fullName']?>
	    </div>

	    <div class="profile-username">
		    @<?=$userInfo['username']?>
	    </div>

	    <div class="profile-username-bio">
		    <?=$userInfo['bio']?>
	    </div>

	    <div class="ads">
		    <!-- Quuzy - Esnek -->
		    <ins class="adsbygoogle"
		         style="display:block"
		         data-ad-client="ca-pub-9896875941850273"
		         data-ad-slot="5702828256"
		         data-ad-format="auto"
		         data-full-width-responsive="true"></ins>
		    <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
		    </script>
	    </div>

    </div>

	<div class="ads">
		<!-- Quuzy - Sidebar -->
		<ins class="adsbygoogle"
		     style="display:inline-block;width:728px;height:90px"
		     data-ad-client="ca-pub-9896875941850273"
		     data-ad-slot="3060216022"></ins>
		<script>
            (adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div>

    <div class="profile-content">

        <div class="profile-posts">

            <?php
                if($userInfo['private'] == '1'){
            ?>
            <div class="alert alert-danger">This profile is private. The contents will be loaded within 24 hours. Please visit this page again.</div>
            <?php
                }
            ?>

            <div class="posts">
            <?php
                $posts = $mysqli->query("SELECT * FROM userposts WHERE username='".$urlParse['folder']."' ORDER BY id ASC LIMIT 10");
                if($posts->num_rows > 0){
                    $ads = 0;
                    while($post = $posts->fetch_assoc()){
            ?>
                <div  class="post play <?=$post['type']?>" data-shortcode="<?=$post['shortcode']?>">
                    <div class="post-img">
                        <?php
                            if($post['type'] == 'photo'){
                        ?>
                        <a href="<?=$imgLink?><?=$post['shortcode']?>/" data-fancybox="gallery">
                            <img src="<?=$imgLink?><?=$post['shortcode']?>/" alt="<?=$post['description']?>"/>
                        </a>
                        <?php
                            }else{
                        ?>
                        <img src="<?=$imgLink?><?=$post['shortcode']?>/" alt="<?=$post['description']?>"/>
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
                                    <div class="icon"><a href="<?=$imgLink?><?=$post['shortcode']?>/" download="<?=$post['shortcode']?>.png"><i class="fas fa-download"></i></a></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php
                        if($ads % $adsLimit == 0){
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
                </div>
            <?php
                        }
                        $ads++;
                    }
                }
            ?>
            </div>
        </div>

    </div>

</section>

<?php 
    require THEMEDIR."footer.php";
?>