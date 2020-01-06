<?php
    require THEMEDIR."header.php";
?>
<section class="home">

	<?php
		include "sidebar.php";
	?>

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