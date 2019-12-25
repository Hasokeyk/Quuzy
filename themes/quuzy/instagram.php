<?php
    require THEMEDIR."header.php";
?>
<section class="home">
    
    <div class="sidebar">
        <ul>
            <li>
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

            <h1>Top 100 Instagram Users</h1>

            <div class="users">

                <?php 
                    $users = $mysqli->query("SELECT * FROM users ORDER BY id DESC LIMIT 100");
                    if($users->num_rows > 0){
                        while($user = $users->fetch_assoc()){
                ?>
                <a href="/instagram/<?=$user['username']?>" class="user">
                    <div class="user-circle">
                        <img src="https://quuzy.com/img/u/<?=($user['username'])?>/" alt="<?=$user['fullName']?>">
                    </div>
                </a>
                <?php 
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