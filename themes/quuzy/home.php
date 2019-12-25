<?php
    require THEMEDIR."header.php";
?>
<section class="home">
    
    <div class="sidebar">
        <ul>
            <li class="active">
                <a href="/">
                    <div class="icon">
                        <i class="fad fa-home"></i>
                    </div>
                    <div class="text">
                        Home
                    </div>
                </a>
            </li>
            <li>
                <a href="/instagram/">
                    <div class="icon">
                        <i class="fad fa-images"></i>
                    </div>
                    <div class="text">
                        Last Posts
                    </div>
                </a>
            </li>
            <li>
                <a href="/instagram/">
                    <div class="icon">
                        <i class="fad fa-users"></i>
                    </div>
                    <div class="text">
                        Last Users
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <div class="home-content">

        <div class="last-user-profiles">

            <h1>Top 15 Users</h1>

            <div class="users">

                <?php 
                    $users = $mysqli->query("SELECT * FROM users ORDER BY id DESC LIMIT 15");
                    if($users->num_rows > 0){
                        while($user = $users->fetch_assoc()){
                ?>
                <a href="/instagram/<?=$user['username']?>" class="user">
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

        <div class="last-posts">

            <h2>Last Posts</h2>

            <div class="posts">
                
                <?php
                    $posts = $mysqli->query("SELECT
                        *
                    FROM
                        userposts As UP,
                        users AS U
                    WHERE
                    	U.username = UP.username AND
                        U.instaID != 0
                    GROUP BY
                        UP.username
                    ORDER BY
                        UP.id
                    DESC
                    LIMIT 30");
                    if($posts->num_rows > 0){
                        $ads = 0;
                        while($post = $posts->fetch_assoc()){
                ?>
                <div  class="post">
                    <div class="post-img">
                        <a href="/instagram/<?=$post['username']?>/"><img src="/img/p/<?=$post['shortcode']?>/" alt="<?=$post['description']?>"/></a>
                    </div>
                    <div class="post-desc" style="display:none">
                        <p>
                        <?=linker($post['description'])?>
                        </p>
                    </div>
                    <div class="post-info">
                        <div class="post-profile">
                            <div class="profile-pic">
                                <a href="/instagram/<?=$post['username']?>/">
                                    <img src="https://quuzy.com/img/u/<?=$post['username']?>/" alt="<?=$post['username']?>">
                                </a>
                            </div>
                        </div>
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
                            </ul>
                        </div>
                    </div>
                </div>
                <?php       
                            if($ads % 6 == 0){
                ?>
                <div class="post ads">
                    <div class="post-img">
                        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <!-- Quuzy - 300 -->
                        <ins class="adsbygoogle"
                            style="display:inline-block;width:300px;height:300px;max-height:300px;"
                            data-ad-client="ca-pub-9896875941850273"
                            data-ad-slot="3060216022"></ins>
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
                        <div class="post-profile">
                            <div class="profile-pic">
                                <a href="/instagram/quuzy/">
                                    <img src="https://quuzy.com/themes/quuzy/assets/img/favicons/apple-icon-114x114.png" alt="Quuzy">
                                </a>
                            </div>
                        </div>
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