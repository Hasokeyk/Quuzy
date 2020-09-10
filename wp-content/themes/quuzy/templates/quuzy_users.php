<?php
	get_header();

	$userID = get_the_ID();

?>

<div class="sidebar">

	<div class="logo">
		<div class="icon">
			<i class="fab fa-instagram"></i>
		</div>
		<div class="text">
			Quuzy
		</div>
	</div>

	<div class="profile-info">

		<div class="profile-pic">
			<div class="profile-circle">
				<?php
					if ( has_post_thumbnail($userID) ) {
						echo get_the_post_thumbnail($userID);
					} else {
						echo 3;
					}
				?>
			</div>
		</div>

		<div class="profile-fullName">
			<?php
				echo get_post_meta( $userID, 'full_name', true );
			?>
		</div>

		<div class="profile-username">
			@<?php
				echo sanitize_title( get_the_title($userID) );
			?>
		</div>

		<div class="profile-istatistic">

			<ul>
				<li>
					<div class="count">
						<?php
							echo thousandsCurrencyFormat(get_post_meta( $userID, 'post_count', true ));
						?>
					</div>
					<div class="text">Posts</div>
				</li>
				<li>
					<div class="count">
						<?php
							echo thousandsCurrencyFormat(get_post_meta( $userID, 'followers_count', true ));
						?>
					</div>
					<div class="text">Followers</div>
				</li>
				<li>
					<div class="count">
						<?php
							echo thousandsCurrencyFormat(get_post_meta( $userID, 'following_count', true ));
						?>
					</div>
					<div class="text">Following</div>
				</li>
			</ul>

		</div>

		<div class="profile-menu">

			<ul>
				<li>
					<a href="/">
						<div class="icon">
							<i class="fal fa-home"></i>
						</div>
						<div class="text">
							Home
						</div>
					</a>
				</li>
				<li class="active">
					<div class="icon">
						<i class="fal fa-tasks-alt"></i>
					</div>
					<div class="text">
						Feed
					</div>
				</li>
				<li>
					<div class="icon">
						<i class="fal fa-portrait"></i>
					</div>
					<div class="text">
						Stories
					</div>
				</li>
				<li>
					<div class="icon">
						<i class="fal fa-tv-retro"></i>
					</div>
					<div class="text">
						IGTV
					</div>
				</li>
			</ul>

		</div>

	</div>

</div>

<div class="profile-content">

	<div class="profile-posts">
		<h1><?php
				echo get_the_title(); ?>'s Posts</h1>

		<?php
			if ( get_post_meta( get_the_ID(), 'private', true ) == '1' ) {
				?>
				<div class="alert alert-danger">This profile is private. The contents will be loaded within 24 hours. Please visit this page again.</div>
				<?php
			}
		?>

		<!--ADS-->
		<div class="yatay-ads">
			<!-- Quuzy - Yatay -->
			<ins class="adsbygoogle"
			     style="display:inline-block;width:728px;height:90px"
			     data-ad-client="ca-pub-9896875941850273"
			     data-ad-slot="3060216022"></ins>
			<script>
                (adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>
		<!--ADS-->

		<div class="posts">

			<?php

				$posts = get_posts( [
					'post_type'   => 'quuzy_user_posts',
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'meta_query'  => [
						[
							'key'     => 'sub_quuzy_user_id',
							'value'   => $userID,
						],
					],
				] );

				$ads = 0;
				foreach ($posts as $post){
					$postLink = get_permalink($post->ID);
					$postType = get_post_meta($post->ID,'post_type',true);
					$postShortCode = get_post_meta($post->ID,'post_shortcode',true);
					$postLikeCount = thousandsCurrencyFormat(get_post_meta($post->ID,'post_like_count',true));
					$postCommentCount = thousandsCurrencyFormat(get_post_meta($post->ID,'post_comment_count',true));
			?>
			<div  class="post play <?php echo $postType; ?>" data-shortcode="<?php echo $postShortCode; ?>">
				<div class="post-img">
					<?php
						if($postType == 'photo'){
					?>
					<a href="<?php echo $postLink; ?>" data-fancybox="gallery">
						<?php
							if(has_post_thumbnail($post->ID)){
								echo get_the_post_thumbnail($post->ID);
							}
						?>
					</a>
					<?php
						}else{
							if(has_post_thumbnail($post->ID)){
								echo get_the_post_thumbnail($post->ID);
							}
						}
					?>
				</div>
				<div class="post-info">
					<div class="post-info-detail">
						<ul>
							<li>
								<div class="icon"><i class="fas fa-heart"></i></div>
								<div class="text"><?php echo $postLikeCount; ?></div>
							</li>
							<li>
								<div class="icon"><i class="fal fa-comment"></i></div>
								<div class="text"><?php echo $postCommentCount; ?></div>
							</li>
							<li class="download-btn">
								<div class="icon"><i class="fas fa-download"></i></div>
								<div class="text"><a href="<?php echo $postLink; ?>" download="<?php echo $postShortCode; ?>.png">Download</a></div>
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
			?>

		</div>
	</div>

</div>


<?php
	get_footer();
?>
