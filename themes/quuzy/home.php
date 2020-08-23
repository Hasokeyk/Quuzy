<?php
    require THEMEDIR."header.php";
?>

	<div class="users-profile-list">
		<?php
			$users = $mysqli->query("SELECT * FROM users ORDER BY id DESC LIMIT 10");
			if($users->num_rows > 0){
				while($user = $users->fetch_assoc()){
					?>
					<a href="/<?=$user['username']?>/" class="user">
						<div class="user-circle">
							<img src="//quuzy.com/img/u/<?=($user['username'])?>/" alt="<?=$user['fullName']?>">
						</div>
						<div class="user-name"><?=($user['username'])?></div>
					</a>
					<?php
				}
			}
		?>
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

	<div class="users-post-list content">
		<div class="posts">
			<?php
				$posts = $mysqli->query("SELECT
                                                        *
                                                    FROM
                                                        userposts AS UP,
                                                        users AS U
                                                    WHERE
                                                        U.username = UP.username AND
                                                        U.instaID != 0 AND
                                                        UP.type = 'photo'
                                                    GROUP BY
                                                        UP.username
                                                    ORDER BY
                                                        UP.id
                                                    DESC
                                                    LIMIT 10");
				if($posts->num_rows > 0){
					$ads = 0;
					while($post = $posts->fetch_assoc()){
						?>
						<div  class="post" data-shortcode="<?=$post['shortcode']?>">
							<div class="post-img">
								<a href="/<?=$post['username']?>/">
									<img src="//quuzy.com/img/p/<?=$post['shortcode']?>/?f=auto" alt="<?=htmlentities($post['description'])?>"/>
								</a>
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
											<div class="text"><?=thousandsCurrencyFormat($post['likeCount'])?></div>
										</li>
										<li>
											<div class="icon"><i class="fal fa-comment"></i></div>
											<div class="text"><?=thousandsCurrencyFormat($post['commentCount'])?></div>
										</li>
										<li class="download-btn">
											<div class="icon"><a href="//quuzy.com/img/p/<?=$post['shortcode']?>/" download="<?=$post['shortcode']?>.png"><i class="fas fa-download"></i></a></div>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<?php
						if($ads % 5 == 0){
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
					}
				}
			?>
		</div>
	</div>

<?php 
    require THEMEDIR."footer.php";
?>