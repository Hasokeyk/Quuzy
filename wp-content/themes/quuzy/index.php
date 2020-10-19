<?php
	get_header();
	get_sidebar();
?>
	<div class="container">

		<?php
			$profiles = get_posts( [
				'post_type'   => 'quuzy_users',
				'post_status' => 'publish',
				'posts_per_page' => 12,
			] );

			if($profiles != null){
		?>
		<div class="profiles">
			<div class="title">
				Last Profile List
			</div>
			<?php
				foreach($profiles as $profile){
			?>
			<a href="<?php echo get_permalink($profile->ID); ?>" title="<?php echo $profile->post_title; ?>" class="profile">
				<div class="profile-pic">
					<?php echo get_the_post_thumbnail($profile->ID)?>
					<svg viewbox="0 0 100 100">
						<circle cx="50" cy="50" r="40"/>
					</svg>
				</div>
				<div class="profile-name">
					<?php echo $profile->post_title; ?>
				</div>
			</a>
			<?php
				}
			?>
		</div>
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

		<div class="profile-content">

			<div class="profile-posts">
				<h1>Last Posts</h1>

				<div class="posts">

					<?php

						$posts = get_posts( [
							'post_type'   => 'quuzy_user_posts',
							'post_status' => 'publish',
							'posts_per_page' => 20,
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

	</div>
<?php
	get_footer();
?>
